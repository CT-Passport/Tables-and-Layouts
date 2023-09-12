<?php
/**
 * Passports
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link https://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Joomla\CMS\Factory;
use CustomTables\CT;

function cron_3_update_visas($logFile, ?string $file)
{
    if($file=== null)
        return;

    $db = JFactory::getDBO();
    require_once 'vendor/autoload.php';
    require_once '../components/com_customtables/customphp/passports.php';
    CronAPP::print_console(' - Update visas.<br/>', $logFile);

    $table = 'h82im_customtables_table_translationsplaces';
    $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $file;
    $reader = ReaderEntityFactory::createReaderFromFile($filePath);
    $reader->open($filePath);

    $version = CronAPP::findVersion($reader); //column "PL OF STAY DETAILS" name
    CronAPP::print_console(' - Excel Sheet version "' . $version . '".<br/>', $logFile);
    $labelIndexes = CronAPP::findColumnLabelIndexes($reader);

    $error = null;
    if(!colNameChecks($version, $labelIndexes,$error))
    {
        $sets = ['es_lasterrormessage=' . $db->quote($error)];
        $query = 'UPDATE #__customtables_table_excelfiles SET ' . implode(',', $sets) . ' WHERE es_file = ' . $db->quote($file);
        $db->setQuery($query);
        $db->execute();
        $reader->close();
    }

    $rows = getRowValuesNoStop($reader);

    if (!is_array($rows)) {
        CronAPP::print_console(' - Main page not found.<br/>', $logFile);
        return;
    }

    $passportsFound = 0;
    $passportsAdded = 0;
    $passportsStarted = false;
    foreach ($rows as $row) {

        if ($passportsStarted) {
            //$index = CronAPP::getColumnIndex('M');
            $PASSPORT = $row[$labelIndexes['PASSPORT №']];

            if ($PASSPORT !== "") {
                $passportsFound += 1;
                $passportNumber = str_replace(' ', '', $PASSPORT);
                echo '$passportNumber='.$passportNumber.'<br/>';
                $passportRow = findPassportByNumber($passportNumber);

                if ($passportRow !== null) {

                    echo 'Passport Number found: ' . $passportNumber . '<br/>';
                    /*
                                        $visaRow = findVisaByPersonId($passportRow['es_person']);
                                        if ($visaRow === null) {
                                            addVisa($passportRow['es_person'], $passportRow, $row, $labelIndexes, $logFile);
                                            echo 'Visa added: ' . $passportNumber . '<br/>';
                                        } else {
                                            echo 'Update Visa: ' . $passportNumber . '<br/>';
                                            if (updateVisa($visaRow, $row, $labelIndexes, $logFile,$error))
                                                echo 'Visa Updated: ' . $passportNumber . '<br/>';
                                        }
                                        */
                } else {
                    $passportID = addPassport($row, $labelIndexes, $error);
                    if ($error !== null)
                        break;

                    $passportsAdded += 1;
                    echo '$passportID: ' . $passportID . ' added<br/>';
                }

            }
        } else {
            if ($row[0] == "STATUS") {
                $passportsStarted = true;
            }
        }
    }

    $sets = ['es_numberofpassports=' . $passportsFound, 'es_numberofpassportsadded=' . $passportsAdded];
    $sets[] = 'es_lasterrormessage=' . $db->quote($error);

    $query = 'UPDATE #__customtables_table_excelfiles SET ' . implode(',', $sets) . ' WHERE es_file = ' . $db->quote($file);
    $db->setQuery($query);
    $db->execute();

    $reader->close();
}

function colNameChecks(string $version, array $labelIndexes,?string $error):bool
{
    $columns = [
        'LAST NAME (Eng)' => 'I',
        'Name (Eng)' => 'J',
        'LAST NAME (Rus)' => 'K',
        'NAME (Rus)' => 'L',
        'PASSPORT №' => 'M',
        'DATE OF EXIT' => 'BM',
        'DATE OF ENTRY' => 'BB',
        'VISA PERIOD' => 'EE',
        'VISA MULTIPLICITY' => ['FR' => 'EY', 'FW' => 'FD'],
        'PL. OF VISA CITY' => 'BY',
        'PL. OF VISA COUNTRY' => 'BX',
        'INVITING COMPANY' => 'EN',
        'PL OF STAY DETAILS' => ['FR' => 'FR', 'FW' => 'FW'],
        'DATE OF BIRTH' => 'N',
        'SEX (Eng.)' => 'DJ',
        'PASS ISSUED BY' => 'AX',
        'PL. OF BIRTH' => 'Z',
        'PASS DATE OF ISSUE' => 'AB',
        'PASS DATE OF VALIDITY' => 'AM',
        'DATE OF BIRTH' => 'N'];
    foreach ($columns as $key => $col) {

        if (is_array($col)) {

            if (CronAPP::getColumnIndex($col[$version]) != $labelIndexes[$key]) {
                $columnName = CronAPP::columnIndexToName($labelIndexes[$key] + 1);
                $error='"' . $key . '"' . ' != "' . $col[$version] . '", the column name is "' . $columnName;
                return false;
            }

        } else {
            if (CronAPP::getColumnIndex($col) != $labelIndexes[$key]) {
                $columnName = CronAPP::columnIndexToName($labelIndexes[$key] + 1);
                $error='"' . $key . '"' . ' != "' . $col . '", the column name is "' . $columnName;
                return false;
            }
        }
    }
    return true;
}

function findCompanyByName(string $name): ?int
{
    $db = Factory::getDBO();
    $sql = 'SELECT id FROM #__customtables_table_companies WHERE es_fullnamerus=' . $db->quote($name) . ' OR es_shortnamerus=' . $db->quote($name);
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0)
        return null;

    $row = $rows[0];
    return $row['id'];
}

function findPlaceOfStayByName(string $name): ?int
{
    $db = Factory::getDBO();
    $sql = 'SELECT id FROM #__customtables_table_stayplaces WHERE es_comment=' . $db->quote($name);
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0)
        return null;

    $row = $rows[0];
    return $row['id'];
}


function updateVisa(array $visaRow, array $xlsRow, array $labelIndexes, $logFile,?string $error): bool
{
    $db = Factory::getDBO();

    $sets = [];

    $visaIssueCountry = $xlsRow[$labelIndexes['PL. OF VISA COUNTRY']];
    //$visaIssueCountry = get Cell ByName($xlsRow, 'BX');

    $countryID = findCountryByName($visaIssueCountry);
    if ($countryID === null) {
        CronAPP::print_console('PL. OF VISA COUNTRY: ' . $visaIssueCountry . '<br/>', $logFile);
        $error='PL. OF VISA COUNTRY: ' . $visaIssueCountry;
        return false;
    }

    $visaIssuePlace = $xlsRow[$labelIndexes['PL. OF VISA CITY']];
    //$visaIssuePlace = get Cell ByName($xlsRow, 'BY');
    $placeID = findPlaceByName($visaIssuePlace, $countryID);
    if ($placeID === null) {
        CronAPP::print_console('PL. OF VISA CITY: ' . $visaIssuePlace . '<br/>', $logFile);
        $error='PL. OF VISA CITY: ' . $visaIssuePlace;
        return false;
    }

    $visaMultiplicity = $xlsRow[$labelIndexes['VISA MULTIPLICITY']];
    //$visaMultiplicity = get CellBy Name($xlsRow, 'EY');

    $visaMultiplicityId = null;
    if ($visaMultiplicity == 'Многократная (до 12 месяцев)') {
        $visaMultiplicityId = 3;
    } elseif ($visaMultiplicity == 'Двукратная (до 3 месяцев)') {
        $visaMultiplicityId = 2;
    } else {
        CronAPP::print_console('UNKNOWN VISA MULTIPLICITY: ' . $visaMultiplicity . '<br/>', $logFile);
        $error='UNKNOWN VISA MULTIPLICITY: ' . $visaMultiplicity;
        return false;
    }

    if ($visaRow['es_multiplicity'] === null) {
        $sets[] = 'es_multiplicity=' . $visaMultiplicityId;
    }

    $visaPeriod = $xlsRow[$labelIndexes['VISA PERIOD']];
    //$visaPeriod = get Cell ByName($xlsRow, 'EE');

    $dateOfEntry = $xlsRow[$labelIndexes['DATE OF ENTRY']];
    //$dateOfEntry = get Cell ByName($xlsRow, 'BB');
    if ($visaRow['es_issuedate'] === null) {
        $sets[] = 'es_issuedate=' . $db->quote($dateOfEntry);
    }

    $dateOfExit = $xlsRow[$labelIndexes['DATE OF EXIT']];
    //$dateOfExit = get Cell ByName($xlsRow, 'BM');

    if ($visaRow['es_visaenddate'] === null) {
        $sets[] = 'es_visaenddate=' . $db->quote($dateOfExit);
    }


    $invitingCompany = $xlsRow[$labelIndexes['INVITING COMPANY']];
    //$invitingCompany = get Cell ByName($xlsRow, 'EN');
    if ($visaRow['es_invcompanyname'] === null) {
        $invitingCompanyID = findCompanyByName($invitingCompany);
        if ($invitingCompanyID !== null) {
            $sets[] = 'es_invcompanyname=' . $invitingCompanyID;
        } else {
            CronAPP::print_console('Inviting Company: ' . $invitingCompany . '<br/>', $logFile);
            die('Unknown Inviting Company.');
        }
    }

    $placeOfStayDetails = $xlsRow[$labelIndexes['PL OF STAY DETAILS']];
    //$placeOfStayDetails = get Cell ByName($xlsRow, 'FR');
    if ($visaRow['es_stayplace'] === null and $placeOfStayDetails !== null) {

        $placeOfStayDetailsID = findPlaceOfStayByName($placeOfStayDetails);
        if ($placeOfStayDetailsID !== null) {
            $sets[] = 'es_stayplace=' . $placeOfStayDetailsID;
        }
    }

    if (count($sets) > 0) {
        $sets[] = 'es_changedate=NOW()';
        $query = 'UPDATE h82im_customtables_table_peoplesrussianvisas SET ' . implode(', ', $sets) . ' WHERE id=' . $visaRow['id'];
        $db->setQuery($query);
        $db->execute();
        return true;
    }

    return false;
}

function addPassport(array $xlsRow, array $labelIndexes, ?string &$error): ?int
{
    $db = JFactory::getDBO();
    $app = Factory::getApplication();
    $row_new = [];

    $lastName = $xlsRow[$labelIndexes['LAST NAME (Eng)']];
    //$lastName = get Cell ByName($xlsRow, 'I');
    $firstName = $xlsRow[$labelIndexes['Name (Eng)']];
    //$firstName = get Cell ByName($xlsRow, 'J');

    $row_new['Surname1'] = $lastName;
    $row_new['Surname2'] = null;
    $row_new['First_Name1'] = $firstName;
    $row_new['First_Name2'] = null;

    $row_new['lastnamerussubj'] = $xlsRow[$labelIndexes['LAST NAME (Rus)']];
    $row_new['firstnamerussubj'] = $xlsRow[$labelIndexes['NAME (Rus)']];

    $MRZ = $lastName . ',' . $firstName;

    $row_new['NativeSurname'] = $lastName;
    $row_new['NativeFirst_Name'] = $firstName;
    $row_new['es_ethnicity'] = null;

    $sets = [];

    $row_new['es_namelinelat'] = $MRZ;
    $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($MRZ);


    $visaIssueCountry = $xlsRow[$labelIndexes['PL. OF VISA COUNTRY']];
    //$visaIssueCountry = get Cell ByName($xlsRow, 'BX');
    $countryID = findCountryByName($visaIssueCountry);
    if ($countryID === null) {
        $error='addPassport:Country "'.$visaIssueCountry.'" not found.';
        return null;
    }

    if ($countryID !== null) {
        $row_new['es_issuecountry'] = $countryID;
        $sets[] = $db->quoteName('es_issuecountry') . '=' . $countryID;
    }

    $row_new['es_type'] = '3';
    $sets[] = $db->quoteName('es_type') . '=3';

    $Passport_Number = $xlsRow[$labelIndexes['PASSPORT №']];
    //$Passport_Number = get Cell ByName($xlsRow, 'M');
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

    $Date_of_Issue = $xlsRow[$labelIndexes['PASS DATE OF ISSUE']];
    //$Date_of_Issue = get Cell ByName($xlsRow, 'AB');
    $newDate = convertPassportDate($Date_of_Issue);
    if ($newDate !== false) {
        $row_new['es_issuedate'] = $newDate;
        $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($newDate);
    } else {
        $error='addPassport:Invalid date format "'.$Date_of_Issue.'" or month abbreviation.';
        return null;
    }

    $Date_of_expiry = $xlsRow[$labelIndexes['PASS DATE OF VALIDITY']];
    //$Date_of_expiry = get Cell ByName($xlsRow, 'AM');
    $newDate = convertPassportDate($Date_of_expiry);
    if ($newDate !== false) {
        $Date_of_expiry = $newDate;
        $row_new['es_expirationdate'] = $newDate;
        $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($newDate);
    } else {
        $error='addPassport:Invalid date format "'.$Date_of_Issue.'" or month abbreviation.';
        return null;
    }

    $currentDate = date('Y-m-d');
    if ($Date_of_expiry >= $currentDate) {
        $row_new['es_validitystatus'] = '1';
        $sets[] = $db->quoteName('es_validitystatus') . '=1';
    } else {
        $row_new['es_validitystatus'] = '2';
        $sets[] = $db->quoteName('es_validitystatus') . '=2';
    }

    //$Date_of_Birth = get Cell ByName($xlsRow, 'N');
    $Date_of_Birth = $xlsRow[$labelIndexes['DATE OF BIRTH']];
    $newDate = convertPassportDate($Date_of_Birth);
    if ($newDate !== false) {
        $row_new['es_birthdate'] = $newDate;
        $sets[] = $db->quoteName('es_birthdate') . '=' . $db->quote($newDate);
    } else {
        $error='addPassport:Invalid date format "'.$Date_of_Issue.'" or month abbreviation.';
        return null;
    }


    /*
        if ($row_new['es_ethnicity'] === null or $row_new['es_ethnicity'] == '') {

            $Nationality = getPredictionValue($prediction, 'Nationality');
            $NationalityID = getNationalityIDOrAddTheRecord($Nationality);
            if ($NationalityID !== null) {
                $row_new['es_ethnicity'] = $NationalityID;
                $sets[] = $db->quoteName('es_ethnicity') . '=' . $NationalityID;
            }
        }
        */

    $gender = strtolower($xlsRow[$labelIndexes['SEX (Eng.)']]);
    $row_new['es_gender'] = ($gender == 'm' ? '1' : '2');
    $sets[] = $db->quoteName('es_gender') . '=' . ($gender == 'm' ? '1' : '2');

    $AuthorityName = $xlsRow[$labelIndexes['PASS ISSUED BY']];
    //$AuthorityName = get Cell ByName($xlsRow, 'AX');
    $AuthorityID = getAuthorityIDOrAddTheRecord($AuthorityName, $countryID);
    if ($AuthorityID !== null) {
        $row_new['es_issueauthority'] = $AuthorityID;
        $sets[] = $db->quoteName('es_issueauthority') . '=' . $AuthorityID;
    }

    $Place_of_birth = $xlsRow[$labelIndexes['PL. OF BIRTH']];
    //$Place_of_birth = get Cell ByName($xlsRow, 'Z');
    $Place_of_birthID = getPlaceCityIDOrAddTheRecord($Place_of_birth, $countryID);
    if ($Place_of_birthID !== null) {
        $row_new['es_birthplace'] = $Place_of_birthID;
        $sets[] = $db->quoteName('es_birthplace') . '=' . $Place_of_birthID;
    }

    $query = 'INSERT #__customtables_table_passports SET ' . implode(',', $sets);
    $db->setQuery($query);
    $db->execute();
    $passportID = $db->insertid();
    $row_new['id'] = $passportID;
    $row_new['es_person'] = null;
    $row_new['es_type'] = 3;
    connect2Person($row_new);

    return $passportID;
}


function addVisa(int $personId, array $passportRow, array $xlsRow, array $labelIndexes, $logFile,?string $error): bool
{
    $db = Factory::getDBO();

    $sets = [];

    $sets[] = 'es_person=' . $personId;
    $sets[] = 'es_passport=' . $passportRow['id'];
    $sets[] = 'es_dbentrydate=NOW()';
    $sets[] = 'es_changedate=NOW()';
    $query = 'INSERT #__customtables_table_peoplesrussianvisas SET ' . implode(', ', $sets);
    $db->setQuery($query);
    $db->execute();
    $id = $db->insertid();

    $query = 'SELECT *, published AS listing_published FROM #__customtables_table_peoplesrussianvisas WHERE id=' . $id . ' LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0) {
        $error='Something terribly wrong.';
        return null;
    }
    $visaRow = $recs[0];
    updateVisa($visaRow, $xlsRow, $labelIndexes, $logFile,$error);
    return $recs[0];
}

function getCellByName(array $xlsRow, string $columnName)
{
    $index = CronAPP::getColumnIndex($columnName);

    if (isset($xlsRow[$index]))
        return $xlsRow[$index];

    return null;
}

function findPlaceByName(string $name, int $countryId): ?int
{
    $db = Factory::getDBO();
    $sql = 'SELECT id FROM #__customtables_table_placescities WHERE es_namelat=' . $db->quote($name);
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0) {
        $sets[] = 'es_namelat=' . $db->quote($name);
        $sets[] = 'es_country=' . $countryId;
        $query = 'INSERT #__customtables_table_placescities SET ' . implode(', ', $sets);
        $db->setQuery($query);
        $db->execute();
        return $db->insertid();
    }
    return $rows[0]['id'];
}

function findCountryByName(string $name): ?int
{
    $db = Factory::getDBO();
    $sql = 'SELECT id FROM h82im_customtables_table_countries WHERE es_namerussubj=' . $db->quote($name) . ' OR es_snamerussubj=' . $db->quote($name);
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0)
        return null;

    return $rows[0]['id'];
}

function findVisaByPersonId(int $personId): ?array
{
    $db = Factory::getDBO();
    $sql = 'SELECT * FROM h82im_customtables_table_peoplesrussianvisas WHERE es_person=' . $personId;
    $db->setQuery($sql);
    $rows = $db->loadAssocList();

    if (count($rows) == 0)
        return null;

    return $rows[0];
}

function findPassportByNumber($passportNumber)
{
    $db = Factory::getDBO();
    $sql = 'SELECT * FROM h82im_customtables_table_passports WHERE es_number=' . $db->quote($passportNumber) . ' OR CONCAT(es_passportseries,es_number)=' . $db->quote($passportNumber);
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0)
        return null;

    return $rows[0];
}

function getRowValuesNoStop($reader): ?array
{
    $sheet = CronAPP::firstSheet($reader);
    if ($sheet === null) {
        $reader->close();
        return null;
    }

    $rows = [];
    foreach ($sheet->getRowIterator() as $row) {
        // do stuff with the row
        $cells = $row->getCells();
        $cellValues = [];

        foreach ($cells as $cell) {
            $value = $cell->getValue();
            if (is_object($value)) {
                if (get_class($value) == 'DateTime') {

                    $val = $value->format('d.m.Y');
                    $cellValues [] = $val;
                } else
                    $cellValues [] = get_class($value);
            } else {
                $cellValues [] = $value;
            }
        }
        if (count($cellValues) > 0)
            $rows[] = $cellValues;
    }
    return $rows;
}
