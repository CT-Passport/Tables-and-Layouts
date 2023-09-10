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

function cron_3_update_visas($logFile)
{
    require_once 'vendor/autoload.php';
    require_once '../components/com_customtables/customphp/passports.php';
    CronAPP::print_console(' - Update visas.<br/>', $logFile);

    $table = 'h82im_customtables_table_translationsplaces';
    $filePath = '1.xlsx';
    $rows = getRowValues($filePath, '01_SK_NORTH BAY_20122020', '0');

    $passportsStarted = false;

    foreach ($rows as $row) {

        $DATE_OF_BIRTH = getCellByName($row, 'N');
        if ($DATE_OF_BIRTH != '' and $DATE_OF_BIRTH != 'DATE OF BIRTH')
            $passportsStarted = true;

        if ($passportsStarted) {
            $index = getColumnIndex('M');

            if ($row[$index] !== "") {
                $passportNumber = str_replace(' ', '', $row[$index]);

                $passportRow = findPassportByNumber($passportNumber);
                if ($passportRow !== null) {

                    echo 'Passport Number found: ' . $passportNumber . '<br/>';

                    $visaRow = findVisaByPersonId($passportRow['es_person']);
                    if ($visaRow === null) {
                        addVisa($passportRow['es_person'], $passportRow, $row);
                        die;
                    }
                } else {
                    echo 'Passport Number NOT found: ' . $passportNumber . '<br/>';
                    //$passportID = addPassport($row);
                    //echo '$passportID: ' . $passportID . '<br/>';
                    die;
                }
            }
        }
    }
}

function addPassport(array $xlsRow): int
{
    $db = JFactory::getDBO();
    $app = Factory::getApplication();
    $row_new = [];

    $lastName = getCellByName($xlsRow, 'I');
    $firstName = getCellByName($xlsRow, 'J');

    $row_new['Surname1'] = $lastName;
    $row_new['Surname2'] = null;
    $row_new['First_Name1'] = $firstName;
    $row_new['First_Name2'] = null;

    $MRZ = $lastName . ',' . $firstName;

    $row_new['NativeSurname'] = $lastName;
    $row_new['NativeFirst_Name'] = $firstName;
    $row_new['es_ethnicity']= null;

    $sets = [];

    $row_new['es_namelinelat'] = $MRZ;
    $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($MRZ);

    $visaIssueCountry = getCellByName($xlsRow, 'BX');
    echo '<br/>Country=' . $visaIssueCountry . '<br/>';
    $countryID = findCountryByName($visaIssueCountry);
    if ($countryID === null) {
        die('Country not found.');
    }

    if ($countryID !== null) {
        $row_new['es_issuecountry'] = $countryID;
        $sets[] = $db->quoteName('es_issuecountry') . '=' . $countryID;
    }

    $row_new['es_type'] = '3';
    $sets[] = $db->quoteName('es_type') . '=3';

    $Passport_Number = getCellByName($xlsRow, 'M');
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

    $Date_of_Issue = getCellByName($xlsRow, 'AB');
    $newDate = convertPassportDate($Date_of_Issue);
    if ($newDate !== false) {
        $row_new['es_issuedate'] = $newDate;
        $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($newDate);
    } else {
        $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
        die(json_encode($res));
    }

    $Date_of_expiry = getCellByName($xlsRow, 'AM');
    $newDate = convertPassportDate($Date_of_expiry);
    if ($newDate !== false) {
        $Date_of_expiry = $newDate;
        $row_new['es_expirationdate'] = $newDate;
        $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($newDate);
    } else {
        $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
        die(json_encode($res));
    }

    $currentDate = date('Y-m-d');
    if ($Date_of_expiry >= $currentDate) {
        $row_new['es_validitystatus'] = '1';
        $sets[] = $db->quoteName('es_validitystatus') . '=1';
    } else {
        $row_new['es_validitystatus'] = '2';
        $sets[] = $db->quoteName('es_validitystatus') . '=2';
    }

    $Date_of_Birth = getCellByName($xlsRow, 'N');
    $newDate = convertPassportDate($Date_of_Birth);
    if ($newDate !== false) {
        $row_new['es_birthdate'] = $newDate;
        $sets[] = $db->quoteName('es_birthdate') . '=' . $db->quote($newDate);
    } else {
        $res = ['status' => 'error', 'message' => 'Invalid date format or month abbreviation.'];
        die(json_encode($res));
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

    $gender = strtolower(getCellByName($xlsRow, 'DJ'));
    $row_new['es_gender'] = ($gender == 'm' ? '1' : '2');
    $sets[] = $db->quoteName('es_gender') . '=' . ($gender == 'm' ? '1' : '2');

    $AuthorityName = getCellByName($xlsRow, 'AX');
    $AuthorityID = getAuthorityIDOrAddTheRecord($AuthorityName, $countryID);
    if ($AuthorityID !== null) {
        $row_new['es_issueauthority'] = $AuthorityID;
        $sets[] = $db->quoteName('es_issueauthority') . '=' . $AuthorityID;
    }

    $Place_of_birth = getCellByName($xlsRow, 'Z');
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


function addVisa(int $personId, array $passportRow, array $xlsRow): bool
{
    $db = Factory::getDBO();

    $sets = [];

    $sets[] = 'es_person=' . $personId;
    $sets[] = 'es_passport=' . $passportRow['id'];

    $visaIssueCountry = getCellByName($xlsRow, 'BX');
    echo '<br/>Country=' . $visaIssueCountry . '<br/>';
    $countryID = findCountryByName($visaIssueCountry);
    if ($countryID === null) {
        die('Country not found.');
    }
    echo '$countryID=' . $countryID . '<br/>';

    $visaIssuePlace = getCellByName($xlsRow, 'BY');
    echo '$visaIssuePlace=' . $visaIssuePlace . '<br/>';
    $placeID = findPlaceByName($visaIssuePlace);
    if ($placeID === null) {
        die('Place not found.');
    }
    echo '$placeID=' . $placeID . '<br/>';

    $visaMultiplicity = getCellByName($xlsRow, 'EY');
    echo '$visaMultiplicity=' . $visaMultiplicity . '<br/>';

    $visaMultiplicityId = null;
    if ($visaMultiplicity == 'Многократная (до 12 месяцев)') {
        $visaMultiplicityId = 3;
    } else {
        die('Unknown Multiplicity.');
    }

    $sets[] = 'es_multiplicity=' . $visaMultiplicityId;

    $visaPeriod = getCellByName($xlsRow, 'EE');
    echo '$visaPeriod=' . $visaPeriod . '<br/>';

    $dateOfEntry = getCellByName($xlsRow, 'BB');
    echo '$dateOfEntry=' . $dateOfEntry . '<br/>';
    $sets[] = 'es_issuedate=' . $db->quote($dateOfEntry);

    $dateOfExit = getCellByName($xlsRow, 'BM');
    echo '$dateOfExit=' . $dateOfExit . '<br/>';
    $sets[] = 'es_visaenddate=' . $db->quote($dateOfExit);
    $sets[] = 'es_dbentrydate=NOW()';
    $sets[] = 'es_changedate=NOW()';


    $query = 'INSERT h82im_customtables_table_peoplesrussianvisas SET ' . implode(', ', $sets);
    $db->setQuery($query);
    $db->execute();
    die;
}

function getColumnIndex($columnName): int
{
    $index = 0;
    $length = strlen($columnName);

    for ($i = 0; $i < $length; $i++) {
        $char = strtoupper($columnName[$i]);
        $index = $index * 26 + (ord($char) - 64);
    }
    return $index - 1;
}


function getCellByName(array $xlsRow, string $columnName)
{
    $index = getColumnIndex($columnName);

    if (isset($xlsRow[$index]))
        return $xlsRow[$index];

    return null;
}

function findPlaceByName(string $name): ?int
{
    $db = Factory::getDBO();
    $sql = 'SELECT id FROM #__customtables_table_placescities WHERE es_namelat=' . $db->quote($name);
    echo '<br/>' . $sql . '<br/>';
    $db->setQuery($sql);
    $rows = $db->loadAssocList();
    if (count($rows) == 0)
        return null;

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


function getRowValues($filePath, $sheetName, $stopCol1Value = ''): ?array
{
    $reader = ReaderEntityFactory::createReaderFromFile($filePath);
    $reader->open($filePath);
    $sheet = findSheet($reader, $sheetName);
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
                //if ($value == $stopCol1Value or $value == '')
                //break;

                $cellValues [] = $value;
            }
        }
        if (count($cellValues) > 0)
            $rows[] = $cellValues;
    }

    $reader->close();
    return $rows;
}

function findSheet($reader, $sheetName)
{
    foreach ($reader->getSheetIterator() as $sheet) {

        if ($sheet->getName() == $sheetName) {
            return $sheet;
        }
    }
    return null;
}
