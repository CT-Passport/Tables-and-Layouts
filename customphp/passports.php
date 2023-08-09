<?php
/**
 * lwspMIservice
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link http://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

function ESCustom_passports($row_new, $row_old)
{
    if (isset($row_new['id']) and (int)$row_new['listing_published'] == 1) {
        $db = JFactory::getDBO();

        if ($row_new['es_passportphotocopy'] != '') {
            if ($row_new['es_ocrjson'] == '') {

                $path = 'http://188.166.79.138/images/passports/';
                $file = $row_new['es_passportphotocopy'];

                echo $row_new['es_passportphotocopy'] . '<br/>';

                $modelId = 'f9d4afd8-fb08-4e67-80cd-3b92e781231c';
                $url = 'https://app.nanonets.com/api/v2/OCR/Model/' . $modelId . '/LabelUrls/?async=false';
                //$url = 'https://joomlaboat.com';
                $payload = 'urls=' . $path . $file;
                $result_str = makePostRequest($url, $payload);

                $app = Factory::getApplication();

                if ($result_str == '') {
                    $app->enqueueMessage('Could not run the Passport recognition. Result is empty.', 'error');
                    return '';
                }

                try {
                    $result = json_decode($result_str);
                } catch (Exception $e) {
                    $app->enqueueMessage('Caught exception: ' . $e->getMessage(), 'error');
                    return '';
                }

                if ($result->message != 'Success') {
                    $app->enqueueMessage('Caught exception: ' . $result->message . ' File: ' . $path . $file, 'error');
                    return '';
                }
                saveJSONString($row_new['id'], $result_str);
                $row_new['es_ocrjson'] == $result_str;
            }

            if ($row_new['es_ocrjson'] != '')
                JSONtoTable($row_new);

            connect2Person($row_new);
            die;
        }
    }
}

function getPersonIDOrAddTheRecord($lastName, $firstName, $dateOfBirth, $gender)
{
    $db = Factory::getDBO();
    $query = 'SELECT id FROM #__customtables_table_people WHERE es_lastnamelat=' . $db->quote($lastName) . ' AND es_firstnamelat=' . $db->quote($firstName) . ' AND es_dateofbirth=' . $db->quote($dateOfBirth) .
        ' AND es_gender=' . $db->quote($gender) . ' LIMIT 1';

    $db->setQuery($query);
    $recs = $db->loadAssocList();

    if (count($recs) == 0) {
        $query = 'INSERT INTO #__customtables_table_people (es_lastnamelat,es_firstnamelat,es_dateofbirth,es_gender)'
            . ' VALUES (' . $db->quote($lastName) . ',' . $db->quote($firstName) . ',' . $db->quote($dateOfBirth) . ',' . $db->quote($gender) . ')';

        $db->setQuery($query);
        $db->execute();
        return $db->insertid();
    }

    return $recs[0]['id'];
}

function connect2Person(array $row_new)
{
    if ($row_new['es_person'] === null or $row_new['es_person'] == '') {

        $db = Factory::getDBO();
        $listing_id = $row_new['id'];
        
        $nameList = explode(',', $row_new['es_namelinelat']);
        $lastName = $nameList[0];
        $firstName = $nameList[1];

        $personId = getPersonIDOrAddTheRecord($lastName, $firstName, $row_new['es_birthdate'], $row_new['es_gender']);

        $sets[] = $db->quoteName('es_person') . '=' . $db->quote($personId);
        if (count($sets) > 0) {
            $query = 'UPDATE #__customtables_table_passports SET ' . implode(',', $sets) . ' WHERE id = ' . $listing_id;
            $db->setQuery($query);
            $db->execute();
        }
    }
}

function getPredictionValue(array $prediction, $label, $changeCase = false): ?string
{
    foreach ($prediction as $p) {
        if ($p->label == $label) {
            if ($changeCase) {
                $str = mb_strtolower($p->ocr_text, 'UTF-8');
                return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
            } else
                return $p->ocr_text;
        }

    }
    return null;
}

function saveJSONValue(array $row_new, array $prediction, string $label, string $fieldName, $changeCase = false): void
{
    if ($row_new['es_' . $fieldName] == '') {
        $listing_id = $row_new['id'];

        $str = getPredictionValue($prediction, $label, $changeCase);

        $sets = [];
        $db = JFactory::getDBO();
        $query = 'UPDATE #__customtables_table_passports SET ' . $db->quoteName('es_' . $fieldName) . '=' . $db->quote($str) . ' WHERE id = ' . $listing_id;
        $db->setQuery($query);
        $db->execute();
    }
}


function JSONtoTable(&$row_new): bool
{
    $listing_id = $row_new['id'];

    $app = Factory::getApplication();
    try {
        $result = json_decode($row_new['es_ocrjson']);
    } catch (Exception $e) {
        $app->enqueueMessage('Caught exception: ' . $e->getMessage(), 'error');
        return false;
    }

    if (count($result->result) != 1) {
        $app->enqueueMessage('Recognition JSON has more than one record.', 'error');
        return false;
    }

    $prediction = $result->result[0]->prediction;
    $db = JFactory::getDBO();

    $sets = [];
    if ($row_new['es_namelinelat'] == '') {
        $Surname = getPredictionValue($prediction, 'Surname', true);
        $First_Name = getPredictionValue($prediction, 'First_Name', true);
        $row_new['es_namelinelat'] = $Surname . ',' . $First_Name;
        $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($Surname . ',' . $First_Name);
    }

    $Code = getPredictionValue($prediction, 'Code');
    $countryID = getCountryID($Code);
    if ($row_new['es_issuecountry'] === null or $row_new['es_issuecountry'] == '') {
        if ($countryID !== null) {
            $row_new['es_issuecountry'] = $countryID;
            $sets[] = $db->quoteName('es_issuecountry') . '=' . $countryID;
        }
    }

    if ($row_new['es_type'] == '') {
        if ($Code == 'RUS') {
            $row_new['es_type'] = '2';
            $sets[] = $db->quoteName('es_type') . '=2';
        } elseif ($Code == '') {
            $row_new['es_type'] = '1';
            $sets[] = $db->quoteName('es_type') . '=1';
        } else {
            $row_new['es_type'] = '3';
            $sets[] = $db->quoteName('es_type') . '=3';
        }
    }

    $Passport_Number = getPredictionValue($prediction, 'Passport_Number');
    if ($row_new['es_number'] == '') {

        $Passport_Number_List = explode(' ', $Passport_Number);
        if (count($Passport_Number_List) == 2) {
            $row_new['es_passportseries'] = $Passport_Number_List[0];
            $sets[] = $db->quoteName('es_passportseries') . '=' . $db->quote($Passport_Number_List[0]);
            $row_new['es_number'] = $Passport_Number_List[1];
            $sets[] = $db->quoteName('es_number') . '=' . $db->quote($Passport_Number_List[1]);
        } else {
            $row_new['es_number'] = $Passport_Number;
            $sets[] = $db->quoteName('es_number') . '=' . $db->quote($Passport_Number);
        }
    }

    if ($row_new['es_issuedate'] === null or $row_new['es_issuedate'] == '') {
        $Date_of_Issue = getPredictionValue($prediction, 'Date_of_Issue');
        $newDate = convertPassportDate($Date_of_Issue);
        if ($newDate !== false) {
            $row_new['es_issuedate'] = $newDate;
            $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($newDate);
        } else {
            echo "Invalid date format or month abbreviation.";
        }
    }

    $Date_of_expiry = getPredictionValue($prediction, 'Date_of_expiry');
    $newDate = convertPassportDate($Date_of_expiry);
    if ($newDate !== false) {
        if ($row_new['es_expirationdate'] === null or $row_new['es_expirationdate'] == '') {
            $row_new['es_expirationdate'] = $newDate;
            $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($newDate);
        }
    } else {
        echo "Invalid date format or month abbreviation.";
    }

    if ($row_new['es_validitystatus'] === null or $row_new['es_validitystatus'] == '') {
        $currentDate = date('Y-m-d');
        if ($Date_of_expiry >= $currentDate) {
            $row_new['es_validitystatus'] = '1';
            $sets[] = $db->quoteName('es_validitystatus') . '=1';
        } else {
            $row_new['es_validitystatus'] = '2';
            $sets[] = $db->quoteName('es_validitystatus') . '=2';
        }
    }

    if ($row_new['es_birthdate'] === null or $row_new['es_birthdate'] == '') {
        $Date_of_Birth = getPredictionValue($prediction, 'Date_of_Birth');
        $newDate = convertPassportDate($Date_of_Birth);
        if ($newDate !== false) {
            $row_new['es_birthdate'] = $newDate;
            $sets[] = $db->quoteName('es_birthdate') . '=' . $db->quote($newDate);
        } else {
            echo "Invalid date format or month abbreviation.";
        }
    }

    if ($row_new['es_ethnicity'] === null or $row_new['es_ethnicity'] == '') {

        $Nationality = getPredictionValue($prediction, 'Nationality');
        $NationalityID = getNationalityIDOrAddTheRecord($Nationality);
        if ($NationalityID !== null) {
            $row_new['es_ethnicity'] = $NationalityID;
            $sets[] = $db->quoteName('es_ethnicity') . '=' . $NationalityID;
        }
    }

    $gender = strtolower(getPredictionValue($prediction, 'Sex'));
    if ($row_new['es_gender'] === null or $row_new['es_gender'] == '') {
        $row_new['es_gender'] = ($gender == 'm' ? '1' : '2');
        $sets[] = $db->quoteName('es_gender') . '=' . ($gender == 'm' ? '1' : '2');
    }

    if ($row_new['es_issueauthority'] === null or $row_new['es_issueauthority'] == '') {

        $AuthorityName = getPredictionValue($prediction, 'Authority');
        $AuthorityID = getAuthorityIDOrAddTheRecord($AuthorityName, $countryID);
        if ($AuthorityID !== null) {
            $row_new['es_issueauthority'] = $AuthorityID;
            $sets[] = $db->quoteName('es_issueauthority') . '=' . $AuthorityID;
        }
    }

    if ($row_new['es_birthplace'] === null or $row_new['es_birthplace'] == '') {

        $Place_of_birth = getPredictionValue($prediction, 'Place_of_birth');
        $Place_of_birthID = getPlaceCityIDOrAddTheRecord($Place_of_birth, $countryID);
        if ($Place_of_birthID !== null) {
            $row_new['es_birthplace'] = $Place_of_birthID;
            $sets[] = $db->quoteName('es_birthplace') . '=' . $Place_of_birthID;
        }
    }

    if ($row_new['es_id'] === null or $row_new['es_id'] == '') {

        $MRZ = str_replace(' ', '', getPredictionValue($prediction, 'MRZ'));
        $Passport_Number_NoSpace = str_replace(' ', '', $Passport_Number);
        $MRZList1 = explode($Passport_Number_NoSpace, $MRZ);

        if (count($MRZList1) == 2) {
            $MRZList2 = explode($Code, $MRZList1[1]);
            if (count($MRZList2) == 2) {
                $MRZList3 = explode(strtoupper($gender), $MRZList2[1]);
                if (count($MRZList3) == 2) {
                    $id = substr($MRZList3[0], 0, -1);
                    $row_new['es_id'] = $id;
                    $sets[] = $db->quoteName('es_id') . '=' . $id;
                }
            }
        }
    }

    if (count($sets) > 0) {
        $query = 'UPDATE #__customtables_table_passports SET ' . implode(',', $sets) . ' WHERE id = ' . $listing_id;
        $db->setQuery($query);
        $db->execute();
    }
    return true;
}

function getPlaceCityIDOrAddTheRecord($PlaceName)
{
    $db = Factory::getDBO();
    $query = 'SELECT id FROM #__customtables_table_placescities WHERE es_namelat=LOWER(' . $db->quote(strtolower($PlaceName)) . ') LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0) {
        $query = 'INSERT INTO #__customtables_table_placescities (es_namelat) VALUES (' . $db->quote($PlaceName) . ')';
        $db->setQuery($query);
        $db->execute();
        return $db->insertid();
    }

    return $recs[0]['id'];
}

function getAuthorityIDOrAddTheRecord($AuthorityName, $countryID)
{
    $db = Factory::getDBO();
    $query = 'SELECT id FROM #__customtables_table_passissueauthorities WHERE es_country=' . $countryID . ' AND es_namelat=LOWER(' . $db->quote(strtolower($AuthorityName)) . ') LIMIT 1';

    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0) {
        $query = 'INSERT INTO #__customtables_table_passissueauthorities (es_namelat, es_country) VALUES (' . $db->quote($AuthorityName) . ',' . $countryID . ')';
        $db->setQuery($query);
        $db->execute();
        return $db->insertid();
    }

    return $recs[0]['id'];
}

function getNationalityIDOrAddTheRecord($Nationality)
{
    $db = Factory::getDBO();
    $query = ' SELECT id FROM #__customtables_table_ethnicity WHERE es_namelat=LOWER(' . $db->quote(strtolower($Nationality)) . ') OR es_synonym=' . $db->quote(strtolower($Nationality)) . ' LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0)
        return null;

    return $recs[0]['id'];
}

function getCountryID($countryISO3Code)
{
    $db = Factory::getDBO();
    $query = ' SELECT id FROM #__customtables_table_countries WHERE es_iso3=' . $db->quote($countryISO3Code) . ' LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0)
        return null;

    return $recs[0]['id'];
}

function convertPassportDate($originalDate)
{
    // Define month abbreviations mapping from Polish to English
    $monthAbbreviations = array(
        'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04',
        'MAY' => '05', 'JUN' => '06', 'JUL' => '07', 'AUG' => '08',
        'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DEC' => '12'
    );

    // Split by '/' to get the abbreviation part and year
    $parts = explode('/', $originalDate);
    if (count($parts) !== 2) {
        return false; // Invalid date format
    }

    $abbreviationPart = trim($parts[1]);

    $yearPart = trim($parts[1]);
    $year = explode(' ', $yearPart)[1];

    // Convert month abbreviation to English
    $monthPart = explode(' ', $abbreviationPart);
    $numericMonth = $monthAbbreviations[$monthPart[0]] ?? '';

    if (!$numericMonth) {
        return false; // Invalid month abbreviation
    }

    // Extract day and year
    $dayYearPart = explode(' ', $parts[0])[0];

    // Convert to yyyy-mm-dd format
    $newDate = sprintf("%04d-%02d-%02d", $year, $numericMonth, $dayYearPart);
    return $newDate;
}

function saveJSONString(int $listing_id, $string): void
{
    $db = JFactory::getDBO();
    $query = 'UPDATE #__customtables_table_passports SET es_ocrjson=' . $db->quote($string) . ' WHERE id = ' . $listing_id;
    echo $query;
    $db->setQuery($query);
    $db->execute();
}

function makePostRequest($url, $payload): string
{
    //'authorization:Basic ' . base64_encode("0e21b7ea-35f7-11ee-850d-262fd2dceba1"),
    $headers = array(
        'accept:application/x-www-form-urlencoded',
        'authorization: Basic ' . base64_encode('e43fbb62-3608-11ee-a104-be008a9db50c:'),
        'Content-Type:application/x-www-form-urlencoded',
        'content-length:' . strlen($payload)
    );
    $ch = curl_init();

    $timeout = 1500;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_NOBODY, false);

    $serverResponse = curl_exec($ch);
    curl_close($ch);

    return $serverResponse;
}
