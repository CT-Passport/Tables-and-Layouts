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

        if ($row_new['es_passportphotocopy'] != '') {

            $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'passports' . DIRECTORY_SEPARATOR . $row_new['es_passportphotocopy'];
            if (file_exists($filePath)) {
                $listing_id = findPassportIDByFile($row_new);

                if ($listing_id === null) {
                    try {
                        $row_new = processPassportFile($row_new);
                    } catch (Exception $e) {
                        $app->enqueueMessage('Caught exception: ' . $e->getMessage(), 'error');
                        return '';
                    }

                } else {
                    //Delete uploaded file
                    unlink($filePath);

                    //Delete new (extra) record
                    $db = Factory::getDBO();
                    $query = 'DELETE FROM #__customtables_table_passports WHERE id=' . $row_new['id'];
                    $db->setQuery($query);
                    $db->execute();

                    //Redirect
                    $returnto = '';//aHR0cDovL2xvY2FsaG9zdC9pbmRleC5waHAvcnUvcGFzc3BvcnRzLXJ1I2EzNQ==
                    $link = '/passports-ru?view=details&listing_id=' . $listing_id . '&returnto=';
                    $jinput = Factory::getApplication()->input;

                    $jinput->set('returnto', base64_encode($link));
                    //$this->setRedirect($link);
                }
            }
        }

        if (!isset($row_new['First_Name1'])) {
            if (isset($row_new['es_namelinelat'])) {
                $parts = explode(',', $row_new['es_namelinelat']);
                if (count($parts) == 2) {
                    $row_new['Surname1'] = $parts[0];
                    $row_new['First_Name1'] = $parts[1];

                    $row_new['Surname2'] = null;
                    $row_new['First_Name2'] = null;
                }

            }
        }

        if (isset($row_new['First_Name1'])) {
            if ($row_new['First_Name1'] !== null and $row_new['First_Name1'] != '' and $row_new['Surname1'] !== null and $row_new['Surname1'] != '') {

                try {
                    connect2Person($row_new);
                } catch (Exception $e) {
                    die('connect2Person: Caught exception: ' . $e->getMessage());
                    return '';
                }
            }
        }
    }
}

function mindeeProcess(array &$row_new)
{
    // cURL install check
    if (!function_exists('curl_init')) {
        exit("cURL isn't installed for " . phpversion());
    }

    $API_KEY = '953d795e9fc83177499c64de0bc1ae25';
    $MIME_TYPE = 'application/pdf'; // change according to the file type
    $FILE_PATH = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'passports' . DIRECTORY_SEPARATOR . $row_new['es_passportphotocopy'];
    $ACCOUNT = 'mindee';
    $VERSION = '1.0';
    $ENDPOINT = 'passport';

    // Open a cURL session to send the document
    $ch = curl_init();

    // Setup headers
    $headers = array(
        "Authorization: Token $API_KEY"
    );

    // Add our file to the request
    $data = array(
        "document" => new CURLFile(
            $FILE_PATH,
            $MIME_TYPE,
            $row_new['es_passportphotocopy']
        )
    );

    // URL for a prediction
    $url = "https://api.mindee.net/v1/products/$ACCOUNT/$ENDPOINT/v$VERSION/predict";

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_RETURNTRANSFER => true
    );

    // Set all options for the cURL request
    curl_setopt_array(
        $ch,
        $options
    );

    // Execute the request & extract the query content into a variable
    $json = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Store the response as an array to allow for easier manipulations
    $result = json_decode($json, true);

    // Print the content of the document as raw json
    if ($result != '') {
        $result_str = json_encode($result, JSON_PRETTY_PRINT);
        saveJSONString($row_new['id'], $result_str, 'es_ocrjsonmindee');
        $row_new['es_ocrjsonmindee'] = $result_str;
    }
}

function nanonetsProcess(array &$row_new, string $filePath)
{
    $modelId = 'f9d4afd8-fb08-4e67-80cd-3b92e781231c';
    $url = 'https://app.nanonets.com/api/v2/OCR/Model/' . $modelId . '/LabelUrls/?async=false';
    $payload = 'urls=' . $filePath;
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
    $row_new['es_ocrjson'] = $result_str;
}

function processPassportFile($row_new)
{
    if ($row_new['es_ocrjson'] == '') {
        $path = 'http://188.166.79.138/images/passports/';
        $file = $row_new['es_passportphotocopy'];
        nanonetsProcess($row_new, $path . $file);
    }

    if ($row_new['es_ocrjson'] != '') {
        try {
            nanonetsJSONtoTable($row_new);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    if (isThereMissingRowValues($row_new)) {

        if ($row_new['es_ocrjsonmindee'] == '') {
            $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'passports' . DIRECTORY_SEPARATOR . $row_new['es_passportphotocopy'];
            mindeeProcess($row_new, $filePath);
        }

        if ($row_new['es_ocrjsonmindee'] != '')
            mindeeJSONtoTable($row_new);
    }

    $db = Factory::getDBO();
    $query = 'SELECT *, published AS listing_published FROM #__customtables_table_passports WHERE id=' . $db->quote($row_new['id']) . ' LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0) {
        die('Something terribly wrong.');
        return $row_new;
    }
    return $recs[0];
}

function isThereMissingRowValues($row_new): bool
{
    $fields = ['Surname1', 'Surname2', 'First_Name1', 'First_Name2', 'es_namelinelat', 'es_issuecountry', 'es_type', 'es_number', 'es_issuedate', 'es_expirationdate'
        , 'es_validitystatus', 'es_birthdate', 'es_gender'];

    foreach ($fields as $field) {
        if (!isset($row_new[$field]) or $row_new[$field] === null or $row_new[$field] == '')
            return true;
    }
    return false;
}

function findPassportIDByFile(&$row_new)
{
    $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'passports' . DIRECTORY_SEPARATOR . $row_new['es_passportphotocopy'];

    $matchingFiles = compareFileByCRC($filePath);

    if (count($matchingFiles) == 0)
        return null;

    foreach ($matchingFiles as $existingPassportFileName) {

        $db = Factory::getDBO();
        $query = 'SELECT id FROM #__customtables_table_passports WHERE es_passportphotocopy=' . $db->quote($existingPassportFileName) . ' LIMIT 1';

        $db->setQuery($query);
        $recs = $db->loadAssocList();

        if (count($recs) == 0) {

            if ($row_new['es_passportphotocopy'] !== $existingPassportFileName) {
                unlink(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'passports' . DIRECTORY_SEPARATOR . $row_new['es_passportphotocopy']);
                $row_new['es_passportphotocopy'] = $existingPassportFileName;

                $db = JFactory::getDBO();
                $query = 'UPDATE #__customtables_table_passports SET es_passportphotocopy=' . $db->quote($row_new['es_passportphotocopy']) . ' WHERE id = ' . $row_new['id'];
                $db->setQuery($query);
                $db->execute();
            }
        } else {
            return $recs[0]['id'];
        }
    }
}

function compareFileByCRC($filePath)
{
    $filePathList = explode(DIRECTORY_SEPARATOR, $filePath);
    $originalFile = end($filePathList);
    if (!is_file($filePath)) {
        return null;
    }

    $fileCRC = hash_file('crc32b', $filePath);
    $originalSHA256 = hash_file('sha256', $filePath);

    $folderPath = dirname($filePath);

    $matchingFiles = array();

    if ($handle = opendir($folderPath)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..' && is_file($folderPath . '/' . $file)) {
                $fileCRC2 = hash_file('crc32b', $folderPath . '/' . $file);
                if ($fileCRC === $fileCRC2) {
                    if ($file != $originalFile) {

                        $fileSHA256 = hash_file('sha256', $folderPath . '/' . $file);
                        if ($originalSHA256 == $fileSHA256)
                            $matchingFiles[] = $file;
                    }
                }
            }
        }
        closedir($handle);
    }

    return $matchingFiles;
}

function getPersonIDOrAddTheRecord($row_new, ?bool &$added)
{
    $added = false;
    if ((int)($row_new['es_type']) == 3)
        $isMigrant = 1;
    else
        $isMigrant = 0;

    if ((int)($row_new['es_issuecountry']) == 1823)
        $citizenshipType = 1;
    else
        $citizenshipType = 2;

    $firstName = $row_new['First_Name1'] . ($row_new['First_Name2'] != '' ? ' ' . $row_new['First_Name2'] : '');

    $db = Factory::getDBO();

    $sets = [];
    $sets[] = 'es_lastnamelat=' . $db->quote($row_new['Surname1']);
    $sets[] = 'es_firstnamelat=' . $db->quote($firstName);

    if ($row_new['es_birthdate'] !== null and $row_new['es_birthdate'] != "")
        $sets[] = 'es_dateofbirth=' . $db->quote($row_new['es_birthdate']);

    $sets[] = 'es_gender=' . $db->quote($row_new['es_gender']);
    $query = 'SELECT * FROM #__customtables_table_people WHERE  ' . implode(' AND ', $sets) . ' LIMIT 1';

    $db->setQuery($query);
    $recs = $db->loadAssocList();

    if (count($recs) == 0) {

        if (!isset($row_new['NativeSurname']))
            $row_new['NativeSurname'] = null;

        if (!isset($row_new['NativeFirst_Name']))
            $row_new['NativeFirst_Name'] = null;

        $query = 'INSERT INTO #__customtables_table_people ('
            . 'es_lastnamelat,es_middlenamelat, es_firstnamelat,'
            . 'es_lastnamenative, es_firstnamenative,'
            . 'es_dateofbirth,es_gender,'
            . 'es_ismigrant,es_citizenshiptype,es_ethnicity,es_user,es_email)'

            . ' VALUES ('
            . $db->quote($row_new['Surname1']) . ',' . $db->quote($row_new['Surname2']) . ',' . $db->quote($firstName) . ','
            . $db->quote($row_new['NativeSurname']) . ',' . $db->quote($row_new['NativeFirst_Name']) . ','
            . ($row_new['es_birthdate'] === null ? 'NULL' : $db->quote($row_new['es_birthdate'])) . ',' . $db->quote($row_new['es_gender']) . ','
            . $db->quote($isMigrant) . ',' . $db->quote($citizenshipType) . ',' . ($row_new['es_ethnicity'] == '' ? 'NULL' : $db->quote($row_new['es_ethnicity'])) . ','
            . ($row_new['es_user'] === null ? 'NULL' : $row_new['es_user']) . ',' . ($row_new['es_email'] === null ? 'NULL' : $db->quote($row_new['es_email'])) . ')';

        $db->setQuery($query);
        $db->execute();
        $added = true;
        return $db->insertid();
    }

    return $recs[0]['id'];
}

function connect2Person(array $row_new): bool
{
    $personAdded = false;
    $db = Factory::getDBO();

    $sets = [];
    $user = Factory::getApplication()->getIdentity();
    if ($user !== null)
        $usergroups = $user->get('groups');
    else
        $usergroups = [];

    $row_new['es_user'] = null;

    if (!isset($row_new['es_type']))
        $row_new['es_type'] = null;

    $row_new['es_email'] = null;

    if (in_array(10, $usergroups)) {

        $row_new['es_user'] = $user->id;
        $row_new['es_type'] = 3;
        $row_new['es_email'] = $user->email;
    }

    if ($row_new['es_person'] === null or $row_new['es_person'] == '') {

        if (in_array(10, $usergroups)) {
            $sets[] = 'es_user=' . $user->id;
            $sets[] = 'es_type=3';
        }

        $listing_id = $row_new['id'];
        $personId = getPersonIDOrAddTheRecord($row_new, $personAdded);

        $sets[] = $db->quoteName('es_person') . '=' . $db->quote($personId);
        $query = 'UPDATE #__customtables_table_passports SET ' . implode(',', $sets) . ' WHERE id = ' . $listing_id;
        $db->setQuery($query);
        $db->execute();

    } else {
        $db = Factory::getDBO();
        $query = 'SELECT * FROM #__customtables_table_people WHERE id= ' . $row_new['es_person'] . ' LIMIT 1';

        $db->setQuery($query);
        $recs = $db->loadAssocList();
        if (count($recs) == 0) {
            $row_new['es_person'] = null;
            connect2Person($row_new);
            return false;
        }

        if (in_array(10, $usergroups)) {
            $sets[] = 'es_user=' . $user->id;
            $sets[] = 'es_ismigrant=1';
        }

        if (($recs[0]['es_ethnicity'] === null or $recs[0]['es_ethnicity'] == '') and $row_new['es_ethnicity'] != '')
            $sets[] = $db->quoteName('es_ethnicity') . '=' . $db->quote($row_new['es_ethnicity']);

        if (count($sets) > 0) {
            $query = 'UPDATE #__customtables_table_people SET ' . implode(',', $sets) . ' WHERE id = ' . $recs[0]['id'];
            $db->setQuery($query);
            $db->execute();
        }
    }
    return $personAdded;
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

function getPredictionValues(array $prediction, $label, $changeCase = false): array
{
    $values = [];

    foreach ($prediction as $p) {
        if ($p->label == $label) {
            if ($changeCase) {
                $str = mb_strtolower($p->ocr_text, 'UTF-8');
                $values[] = mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
            } else
                $values[] = $p->ocr_text;
        }
    }
    return $values;
}

function nanonetsJSONtoTableProcessPrediction(&$row_new, $prediction): bool
{
    $listing_id = $row_new['id'];
    $app = Factory::getApplication();

    $Code = getPredictionValue($prediction, 'Code');

    $db = JFactory::getDBO();

    $MRZ = getPredictionValue($prediction, 'MRZ');
    if ($MRZ !== null) {
        $MRZ = str_replace(' ', '', $MRZ);
        $MRZ = str_replace('u003c', '<', $MRZ);
    }

    if ($MRZ !== null)
        $nameFromMRZ = namePartsFromMRZ($row_new, $Code, $MRZ);

    $row_new['NativeSurname'] = getPredictionValue($prediction, 'Surname', true);
    $row_new['NativeFirst_Name'] = getPredictionValue($prediction, 'First_Name', true);

    $sets = [];

    if ($MRZ !== null) {
        if ($nameFromMRZ[0] != '' and $nameFromMRZ[2] != '') {
            if ($row_new['es_namelinelat'] == '') {
                $row_new['es_namelinelat'] = $nameFromMRZ[0] . ($nameFromMRZ[1] != '' ? ' ' . $nameFromMRZ[1] : '') . ',' . $nameFromMRZ[2] . ($nameFromMRZ[3] != '' ? ' ' . $nameFromMRZ[3] : '');
                $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($row_new['es_namelinelat']);
            }
        }
    }

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
            $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
            die(json_encode($res));
        }
    }

    $Date_of_expiry = getPredictionValue($prediction, 'Date_of_expiry');
    $newDate = convertPassportDate($Date_of_expiry);
    if ($newDate !== false) {
        $Date_of_expiry = $newDate;
        if ($row_new['es_expirationdate'] === null or $row_new['es_expirationdate'] == '') {
            $row_new['es_expirationdate'] = $newDate;
            $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($newDate);
        }
    } else {
        $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
        die(json_encode($res));
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
            $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
            die(json_encode($res));
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

    if ($countryID !== null) {

        if ($row_new['es_issueauthority'] === null or $row_new['es_issueauthority'] == '') {
            $AuthorityName = getPredictionValue($prediction, 'Authority');
            $AuthorityID = getAuthorityIDOrAddTheRecord($AuthorityName, $countryID);
            if ($AuthorityID !== null) {
                $row_new['es_issueauthority'] = $AuthorityID;
                $sets[] = $db->quoteName('es_issueauthority') . '=' . $AuthorityID;
            }
        }
    }

    /*
    if ($row_new['es_issueplace'] === null or $row_new['es_issueplace'] == '') {


        $Authorities = getPredictionValues($prediction, 'Authority');

        if (count($Authorities) > 0) {
            print_r($Authorities);
            die;

            $row_new['es_issueplace'] = implode(', ', $Authorities);
            $sets[] = $db->quoteName('es_issueplace') . '=' . $db->quote(implode(', ', $Authorities));
        }
    }
    */

    if ($row_new['es_birthplace'] === null or $row_new['es_birthplace'] == '') {
        $Place_of_birth = getPredictionValue($prediction, 'Place_of_birth');
        $Place_of_birthID = getPlaceCityIDOrAddTheRecord($Place_of_birth, $countryID);
        if ($Place_of_birthID !== null) {
            $row_new['es_birthplace'] = $Place_of_birthID;
            $sets[] = $db->quoteName('es_birthplace') . '=' . $Place_of_birthID;
        }
    }

    if ($MRZ !== null) {
        if ($row_new['es_id'] === null or $row_new['es_id'] == '') {

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
    }

    if (count($sets) > 0) {
        $query = 'UPDATE #__customtables_table_passports SET ' . implode(',', $sets) . ' WHERE id = ' . $listing_id;
        $db->setQuery($query);
        $db->execute();
    }
    return true;
}

function nanonetsJSONtoTable(&$row_new): bool
{
    $listing_id = $row_new['id'];
    $app = Factory::getApplication();
    try {
        $result = json_decode($row_new['es_ocrjson']);
    } catch (Exception $e) {
        $app->enqueueMessage('Caught exception: ' . $e->getMessage(), 'error');
        return false;
    }

    foreach ($result->result as $res) {
        nanonetsJSONtoTableProcessPrediction($row_new, $res->prediction);
    }
    return true;
}

function namePartsFromMRZ(array &$row_new, string $Code, ?string $MRZ): ?array
{
    $Surname1 = '';
    $Surname2 = '';

    if ($MRZ !== null) {
        $MRZList = explode('<<', $MRZ);

        if (substr($MRZList[0], 0, 3) == $Code) {
            $n = substr($MRZList[0], 3, strlen($MRZList[0]) - 3);
            $MRZList2 = explode('<', $n);
            $Surname1 = $MRZList2[0];
            if (count($MRZList2) > 1)
                $Surname2 = $MRZList2[1];
        } else {

            $list = explode('<', $MRZList[0]);
            if (count($list) > 1) {

                if (substr($list[1], 0, 3) == $Code) {
                    $Surname1 = substr($list[1], 3, strlen($MRZList[0]) - 3);
                    if (count($list) > 2)
                        $Surname2 = $list[2];
                } else {
                    $res = ['status' => 'error', 'message' => 'Invalid MRZ:' . $MRZ];
                    die(json_encode($res));
                }
            } else {
                if (substr($list[0], 2, 3) == $Code) {
                    $Surname1 = substr($list[0], 5, strlen($list[0]) - 5);
                } else {
                    $res = ['status' => 'error', 'message' => 'Invalid MRZ:' . $MRZ];
                    die(json_encode($res));
                }
            }
        }

        $MRZList2 = explode('<', $MRZList[1]);
        $First_Name1 = $MRZList2[0];
        $First_Name2 = $MRZList2[1] ?? '';

        $row_new['Surname1'] = mb_convert_case(mb_strtolower($Surname1, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $row_new['Surname2'] = mb_convert_case(mb_strtolower($Surname2, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $row_new['First_Name1'] = mb_convert_case(mb_strtolower($First_Name1, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        $row_new['First_Name2'] = mb_convert_case(mb_strtolower($First_Name2, 'UTF-8'), MB_CASE_TITLE, "UTF-8");
        return [$Surname1, $Surname2, $First_Name1, $First_Name2];
    }

    return null;
}

function mindeeJSONtoTable(&$row_new): bool
{
    $listing_id = $row_new['id'];

    $app = Factory::getApplication();
    try {
        $result = json_decode($row_new['es_ocrjsonmindee']);
    } catch (Exception $e) {
        $app->enqueueMessage('Caught exception: ' . $e->getMessage(), 'error');
        return false;
    }

    if ($result->api_request->status != "success") {
        $app->enqueueMessage('Caught exception: ' . implode(',', $result->api_request->error), 'error');

        $res = ['status' => 'error', 'message' => json_encode($result->api_request->error)];
        die(json_encode($res));
        return false;
    }

    $prediction = $result->document->inference->prediction;
    $Code = $prediction->country->value;

    $db = JFactory::getDBO();
    $mrz1 = str_replace(' ', '', $prediction->mrz1->value);
    $mrz2 = str_replace(' ', '', $prediction->mrz2->value);

    $nameFromMRZ = namePartsFromMRZ($row_new, $Code, $mrz1);

    $row_new['NativeSurname'] = $prediction->surname->value;
    $row_new['NativeFirst_Name'] = $prediction->given_names[0]->value;
    if (isset($prediction->given_names[1]))
        $row_new['NativeFirst_Name'] .= ' ' . $prediction->given_names[1]->value;

    $sets = [];
    if ($nameFromMRZ[0] != '' and $nameFromMRZ[2] != '') {
        if ($row_new['es_namelinelat'] == '') {
            $row_new['es_namelinelat'] = $nameFromMRZ[0] . ($nameFromMRZ[1] != '' ? ' ' . $nameFromMRZ[1] : '') . ',' . $nameFromMRZ[2] . ($nameFromMRZ[3] != '' ? ' ' . $nameFromMRZ[3] : '');
            $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($row_new['es_namelinelat']);
        }
    }

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

    $Passport_Number = $prediction->id_number->value;
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

    $issuance_date = $prediction->issuance_date->value;
    $newDate = date_parse($issuance_date);
    $Date_of_Issue = sprintf("%04d-%02d-%02d", $newDate['year'], $newDate['month'], $newDate['day']);

    if ($row_new['es_issuedate'] === null or $row_new['es_issuedate'] == '') {
        $row_new['es_issuedate'] = $Date_of_Issue;
        $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($Date_of_Issue);
    }

    $expiry_date = $prediction->expiry_date->value;
    $newDate = date_parse($expiry_date);
    $Date_of_expiry = sprintf("%04d-%02d-%02d", $newDate['year'], $newDate['month'], $newDate['day']);

    if ($newDate !== false) {
        if ($row_new['es_expirationdate'] === null or $row_new['es_expirationdate'] == '') {
            $row_new['es_expirationdate'] = $Date_of_expiry;
            $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($Date_of_expiry);

            $row_new['es_issuedate'] = $Date_of_Issue;
            $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($Date_of_Issue);
        }
    } else {
        $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
        die(json_encode($res));
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

        $newDate = date_parse($prediction->birth_date->value);
        $Date_of_Birth = sprintf("%04d-%02d-%02d", $newDate['year'], $newDate['month'], $newDate['day']);
        $row_new['es_birthdate'] = $Date_of_Birth;
        $sets[] = $db->quoteName('es_birthdate') . '=' . $db->quote($Date_of_Birth);
    }

    $gender = strtolower($prediction->gender->value);
    if ($row_new['es_gender'] === null or $row_new['es_gender'] == '') {
        $row_new['es_gender'] = ($gender == 'm' ? '1' : '2');
        $sets[] = $db->quoteName('es_gender') . '=' . ($gender == 'm' ? '1' : '2');
    }

    if ($mrz2 !== null) {
        if ($row_new['es_id'] === null or $row_new['es_id'] == '') {

            $Passport_Number_NoSpace = str_replace(' ', '', $Passport_Number);
            $MRZList1 = explode($Passport_Number_NoSpace, $mrz2);

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
    die("ADD COUNTRY ID");

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
    if (strlen($originalDate) == 10) {
        $parts = explode('.', $originalDate);

        if (count($parts) == 3) {
            //Russian format
            $year = (int)$parts[2];
            $month = (int)$parts[1];
            $day = (int)$parts[0];
            return sprintf("%04d-%02d-%02d", $year, $month, $day);
        }
    }

    // Define month abbreviations mapping from Polish to English
    $monthAbbreviations = array(
        'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04',
        'MAY' => '05', 'JUN' => '06', 'JUL' => '07', 'AUG' => '08',
        'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DEC' => '12'
    );

    // Split by '/' to get the abbreviation part and year
    $parts = explode('/', $originalDate);
    if (count($parts) !== 2) {
        $parts = explode(' ', $originalDate);
        $dayYearPart = trim($parts[0]);

        if (!isset($parts[1]))
            return false;

        $abbreviationPart = trim($parts[1]);
        $numericMonth = $monthAbbreviations[$abbreviationPart] ?? '';

        if (!isset($parts[2]))
            return false;

        $year = trim($parts[2]);
    } else {
        // Extract day and year
        $dayYearPart = explode(' ', $parts[0])[0];

        $abbreviationPart = trim($parts[1]);
        // Convert month abbreviation to English
        $monthPart = explode(' ', $abbreviationPart);
        $numericMonth = $monthAbbreviations[$monthPart[0]] ?? '';

        $yearPart = trim($parts[1]);
        $year = explode(' ', $yearPart)[1];
    }

    if (!$numericMonth) {
        return false; // Invalid month abbreviation
    }

    // Convert to yyyy-mm-dd format
    return sprintf("%04d-%02d-%02d", $year, $numericMonth, $dayYearPart);
}

function saveJSONString(int $listing_id, $string, $fieldName = 'es_ocrjson'): void
{
    $db = JFactory::getDBO();
    $query = 'UPDATE #__customtables_table_passports SET ' . $fieldName . '=' . $db->quote($string) . ' WHERE id = ' . $listing_id;
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
