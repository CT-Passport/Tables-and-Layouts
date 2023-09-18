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
    if ($file === null)
        return;

    $p = new updatePassportAndVisas($logFile, $file);
    if ($p->getReader())
        $p->read();
}

class updatePassportAndVisas
{
    var $reader;
    var $error;
    var $numberofvisas;
    var $numberofpeople;
    var $numberofprojects;

    var $logFile;
    var $file;
    var $labelIndexes;
    var array $workCompanies;
    var array $invitingCompanies;
    var string $version;

    function __construct($logFile, ?string $file)
    {
        $this->logFile = $logFile;
        $this->file = $file;
        $this->error = null;

        $this->passportsFound = 0;
        $this->numberofvisas = 0;
        $this->numberofpeople = 0;

        $this->numberofprojects = [];
        $this->workCompanies = [];
        $this->invitingCompanies = [];

        require_once 'vendor/autoload.php';
        require_once '../components/com_customtables/customphp/passports.php';
        CronAPP::print_console(' - Update visas.<br/>', $this->logFile);
    }

    function getReader()
    {
        $db = JFactory::getDBO();
        $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $this->file;
        $this->reader = ReaderEntityFactory::createReaderFromFile($filePath);
        $this->reader->open($filePath);

        $this->version = CronAPP::findVersion($this->reader); //column "PL OF STAY DETAILS" name
        CronAPP::print_console(' - Excel Sheet version "' . $this->version . '".<br/>', $this->logFile);
        $this->labelIndexes = CronAPP::findColumnLabelIndexes($this->reader);

        if (!$this->colNameChecks($this->version)) {
            $sets = ['es_lasterrormessage=' . $db->quote($this->error)];
            $query = 'UPDATE #__customtables_table_excelfiles SET ' . implode(',', $sets) . ' WHERE es_file = ' . $db->quote($this->file);
            $db->setQuery($query);
            $db->execute();
            $this->reader->close();
            return false;
        }
        return true;
    }

    function colNameChecks(string $version): bool
    {
        $columns = [
            'LAST NAME (Eng)' => 'I',
            'Name (Eng)' => 'J',
            'LAST NAME (Rus)' => 'K',
            'NAME (Rus)' => 'L',
            'PASSPORT №' => 'M',
            'DATE OF EXIT' => ['FR' => 'BM', 'FW' => 'BM', 'EU' => 'BK', 'EY' => 'BK'],
            'DATE OF ENTRY' => ['FR' => 'BB', 'FW' => 'BB', 'EU' => 'AZ', 'EY' => 'AZ'],
            'VISA PERIOD' => ['FR' => 'EE', 'FW' => 'EE', 'EU' => 'EB', 'EY' => 'EB'],
            'VISA MULTIPLICITY' => ['FR' => 'EY', 'FW' => 'FD', 'EU' => 'ET', 'EY' => 'ET'],
            'PL. OF VISA CITY' => ['FR' => 'BY', 'FW' => 'BY', 'EU' => null, 'EY' => null],
            'PL. OF VISA COUNTRY' => ['FR' => 'BX', 'FW' => 'BX', 'EU' => null, 'EY' => null],
            'INVITING COMPANY' => ['FR' => 'EN', 'FW' => 'EN', 'EU' => 'EK', 'EY' => 'EK'],
            'PL OF STAY DETAILS' => ['FR' => 'FR', 'FW' => 'FW', 'EU' => null, 'EY' => null],

            'DATE OF BIRTH' => 'N',
            'SEX (Eng.)' => ['FR' => 'DJ', 'FW' => 'DJ', 'EU' => 'DG', 'EY' => 'DG'],
            'PASS ISSUED BY' => 'AX',
            'PL. OF BIRTH' => 'Z',
            'PASS DATE OF ISSUE' => 'AB',
            'PASS DATE OF VALIDITY' => 'AM',
            'PL. OF RESIDENCE' => ['FR' => 'AZ', 'FW' => 'AZ', 'EU' => 'AX', 'EY' => 'AX'],
            'DATE OF BIRTH' => 'N',

            'COMPANY' => ['FR' => 'DU', 'FW' => 'DU', 'EU' => 'DR', 'EY' => 'DR'],
            'COMPANY ADDRESS' => ['FR' => 'DW', 'FW' => 'DW', 'EU' => 'DT', 'EY' => 'DT'],
            //'ENTERING PERSON' => 'EA',
            'JOB POSITION Eng' => ['FR' => 'DK', 'FW' => 'DK', 'EU' => 'DH', 'EY' => 'DH'],
            //'JOB POSITION Rus' => 'DL'


            'PL OF STAY REGION' => ['FR' => 'FE', 'FW' => 'FJ', 'EU' => 'FE', 'EY' => 'FE'],
            'TYPE PL OF STAY' => ['FR' => 'FF', 'FW' => 'FK', 'EU' => 'FF', 'EY' => 'FF'],
            'PL OF STAY CITY' => ['FR' => 'FG', 'FW' => 'FL', 'EU' => 'FG', 'EY' => 'FG'],
            'TYPE PL OF STAY DISTRICT' => ['FR' => 'FH', 'FW' => 'FM', 'EU' => 'FH', 'EY' => 'FH'],
            'PL OF STAY DISTRICT' => ['FR' => 'FI', 'FW' => 'FN', 'EU' => 'FI', 'EY' => 'FI'],
            'TYPE PL OF STAY STREET' => ['FR' => 'FJ', 'FW' => 'FO', 'EU' => 'FJ', 'EY' => 'FJ'],
            'PL OF STAY STREET' => ['FR' => 'FK', 'FW' => 'FP', 'EU' => 'FK', 'EY' => 'FK'],
            'TYPE PL OF STAY HOUSE' => ['FR' => 'FL', 'FW' => 'FQ', 'EU' => 'FL', 'EY' => 'FL'],
            'PL OF STAY HOUSE' => ['FR' => 'FM', 'FW' => 'FR', 'EU' => 'FM', 'EY' => 'FM'],
            'PL OF STAY HOUSING' => ['FR' => 'FN', 'FW' => 'FS', 'EU' => 'FN', 'EY' => 'FN'],
            'PL OF STAY BUILDING' => ['FR' => 'FO', 'FW' => 'FT', 'EU' => 'FO', 'EY' => 'FO'],
            'PL OF STAY FLAT' => ['FR' => 'FP', 'FW' => 'FU', 'ET' => 'FP', 'EY' => 'FP']
        ];

        foreach ($columns as $key => $col) {

            if (is_array($col)) {

                if ($col[$version] == null) {
                    if ($version == 'EU') {
                        if ($key == 'PL. OF VISA CITY')
                            $this->labelIndexes[$key] = CronAPP::getColumnIndex('BV');
                        elseif ($key == 'PL. OF VISA COUNTRY')
                            $this->labelIndexes[$key] = CronAPP::getColumnIndex('DV');
                    }

                } else {
                    if (CronAPP::getColumnIndex($col[$version]) != $this->labelIndexes[$key]) {
                        $columnName = CronAPP::columnIndexToName($this->labelIndexes[$key] + 1);
                        $this->error = '"' . $key . '"' . ' != "' . $col[$version] . '", the column name is "' . $columnName . '".';
                        return false;
                    }
                }

            } else {
                if (isset($this->labelIndexes[$key])) {
                    if (CronAPP::getColumnIndex($col) != $this->labelIndexes[$key]) {

                        if ($this->labelIndexes[$key] === null) {
                            //$this->error = '"' . $key . '"' . ' != "' . $col . '", the column name is ""';
                        } else {
                            $columnName = CronAPP::columnIndexToName($this->labelIndexes[$key] + 1);
                            $this->error = '"' . $key . '"' . ' != "' . $col . '", the column name is "' . $columnName . '"';
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    function read()
    {
        $db = JFactory::getDBO();
        $rows = $this->getRowValuesNoStop();

        if (!is_array($rows)) {
            CronAPP::print_console(' - Main page not found.<br/>', $this->logFile);
            return;
        }

        $passportsStarted = false;
        foreach ($rows as $row) {

            if ($passportsStarted) {
                //$index = CronAPP::getColumnIndex('M');
                $PASSPORT = $row[$this->labelIndexes['PASSPORT №']];

                if ($PASSPORT !== "") {
                    $this->passportsFound += 1;
                    $passportNumber = str_replace(' ', '', $PASSPORT);

                    CronAPP::print_console(' - Passport Number:' . $passportNumber . '<br/>');
                    $passportRow = $this->findPassportByNumber($passportNumber);

                    if ($passportRow !== null) {
                        CronAPP::print_console(' - Passport Number found: ' . $passportNumber . '<br/>');

                        $personAdded = false;
                        $this->updatePassport($passportRow, $row, $personAdded);
                        if ($personAdded)
                            $this->numberofpeople += 1;

                    } else {
                        $passportRow = $this->addPassport($row, $personAdded);
                        echo 'Passport Added<br/>';
                        if ($personAdded)
                            $this->numberofpeople += 1;

                        if ($this->error !== null)
                            break;

                        $passportID = $passportRow['id'];
                        CronAPP::print_console(' - PassportID: ' . $passportID . ' added<br/>');
                    }

                    if ($passportRow !== null) {

                        $dateOfEntry = CronAPP::convertDate($row[$this->labelIndexes['DATE OF ENTRY']]);

                        if ($passportRow['es_person'] === null) {
                            
                            print_r($passportRow);
                            echo '<hr/>';
                            print_r($row);
                            die;
                        }

                        $visaRow = $this->findVisaByPersonId($passportRow['es_person'], $dateOfEntry);
                        if ($visaRow === null) {
                            if ($this->addVisa($passportRow, $row)) {
                                $this->numberofvisas += 1;
                                CronAPP::print_console(' - Visa added: ' . $passportNumber . '<br/>');
                            }
                        } else {

                            CronAPP::print_console(' - Update Visa: ' . $passportNumber . '<br/>');
                            if ($this->updateVisa($visaRow, $row))
                                CronAPP::print_console(' - Visa Updated: ' . $passportNumber . '<br/>');
                        }
                    }
                }
            } else {
                if ($row[0] == "STATUS") {
                    $passportsStarted = true;
                }
            }
        }

        $sets = ['es_numberofpassports=' . $this->passportsFound, 'es_numberofvisas=' . $this->numberofvisas];
        $sets[] = 'es_workcompanies=' . count($this->workCompanies);
        $sets[] = 'es_numberofcompanies=' . count($this->invitingCompanies);
        $sets[] = 'es_numberofproject=' . count($this->numberofprojects);


        $sets[] = 'es_lasterrormessage=' . $db->quote($this->error);
        $query = 'UPDATE #__customtables_table_excelfiles SET ' . implode(',', $sets) . ' WHERE es_file = ' . $db->quote($this->file);
        $db->setQuery($query);
        $db->execute();

        $this->reader->close();

        echo ' - Done.';
    }

    function getRowValuesNoStop(): ?array
    {
        $sheet = CronAPP::firstSheet($this->reader);
        if ($sheet === null) {
            $this->reader->close();
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

    function updatePassport(array $passportRow, array $xlsRow, bool &$personAdded): bool
    {
        $db = JFactory::getDBO();

        $lastName = $xlsRow[$this->labelIndexes['LAST NAME (Eng)']];
        $firstName = $xlsRow[$this->labelIndexes['Name (Eng)']];
        $passportRow['NativeSurname'] = $lastName;
        $passportRow['NativeFirst_Name'] = $firstName;
        $passportRow['Surname1'] = $lastName;
        $passportRow['Surname2'] = null;
        $passportRow['First_Name1'] = $firstName;
        $passportRow['First_Name2'] = null;
        $passportRow['lastnamerussubj'] = $xlsRow[$this->labelIndexes['LAST NAME (Rus)']];
        $passportRow['firstnamerussubj'] = $xlsRow[$this->labelIndexes['NAME (Rus)']];

        $MRZ = $lastName . ',' . $firstName;
        $sets = [];

        if ($passportRow['es_namelinelat'] === null) {
            $passportRow['es_namelinelat'] = $MRZ;
            $sets[] = $db->quoteName('es_namelinelat') . '=' . $db->quote($MRZ);
        }

        if ($this->version == "EY") {
            $index = CronAPP::getColumnIndex('EW');
            $visaIssueCountry = $xlsRow[$index];
        } else {
            $visaIssueCountry = $xlsRow[$this->labelIndexes['PL. OF VISA COUNTRY']];
        }

        if ($visaIssueCountry !== null and $visaIssueCountry != "") {
            $countryID = $this->findCountryByName($visaIssueCountry);
            if ($countryID === null) {
                $this->error = 'Add Passport: Country "' . $visaIssueCountry . '" not found.';
                return false;
            }
        }

        if ($passportRow['es_issuecountry'] === null) {
            if ($countryID !== null) {
                $passportRow['es_issuecountry'] = $countryID;
                $sets[] = $db->quoteName('es_issuecountry') . '=' . $countryID;
            }
        }

        if ($passportRow['es_number'] === null) {
            $Passport_Number = $xlsRow[$this->labelIndexes['PASSPORT №']];
            $Passport_Number_List = explode(' ', $Passport_Number);
            if (count($Passport_Number_List) == 2) {
                $passportRow['es_passportseries'] = $Passport_Number_List[0];
                $sets[] = $db->quoteName('es_passportseries') . '=' . $db->quote($Passport_Number_List[0]);
                $passportRow['es_number'] = $Passport_Number_List[1];
                $sets[] = $db->quoteName('es_number') . '=' . $db->quote($Passport_Number_List[1]);
            } else {
                $passportRow['es_number'] = $Passport_Number;
                $sets[] = $db->quoteName('es_number') . '=' . $db->quote($Passport_Number);
            }
        }

        if ($xlsRow[$this->labelIndexes['PASS DATE OF ISSUE']] !== null and $xlsRow[$this->labelIndexes['PASS DATE OF ISSUE']] !== '') {
            if ($passportRow['es_issuedate'] === null) {
                $newDate = CronAPP::convertDate($xlsRow[$this->labelIndexes['PASS DATE OF ISSUE']]);
                if ($newDate !== false) {
                    $passportRow['es_issuedate'] = $newDate;
                    $sets[] = $db->quoteName('es_issuedate') . '=' . $db->quote($newDate);
                } else {
                    $this->error = 'PASS DATE OF ISSUE:Invalid date format "' . $xlsRow[$this->labelIndexes['PASS DATE OF ISSUE']] . '" or month abbreviation.';
                    return false;
                }
            }
        }

        if ($xlsRow[$this->labelIndexes['PASS DATE OF VALIDITY']] !== null and $xlsRow[$this->labelIndexes['PASS DATE OF VALIDITY']] != "") {
            if ($passportRow['es_expirationdate'] === null) {
                $newDate = CronAPP::convertDate($xlsRow[$this->labelIndexes['PASS DATE OF VALIDITY']]);
                if ($newDate !== false) {
                    $Date_of_expiry = $newDate;
                    $passportRow['es_expirationdate'] = $newDate;
                    $sets[] = $db->quoteName('es_expirationdate') . '=' . $db->quote($newDate);
                } else {
                    $this->error = 'PASS DATE OF VALIDITY:Invalid date format "' . $newDate . '" or month abbreviation.';
                    return false;
                }
            }
        }

        if ($passportRow['es_validitystatus'] === null) {
            $currentDate = date('Y-m-d');
            if ($Date_of_expiry >= $currentDate) {
                $passportRow['es_validitystatus'] = '1';
                $sets[] = $db->quoteName('es_validitystatus') . '=1';
            } else {
                $passportRow['es_validitystatus'] = '2';
                $sets[] = $db->quoteName('es_validitystatus') . '=2';
            }
        }

        if ($xlsRow[$this->labelIndexes['DATE OF BIRTH']] !== null and $xlsRow[$this->labelIndexes['DATE OF BIRTH']] != "") {
            if ($passportRow['es_birthdate'] === null) {
                $newDate = CronAPP::convertDate($xlsRow[$this->labelIndexes['DATE OF BIRTH']]);
                if ($newDate !== false) {
                    $passportRow['es_birthdate'] = $newDate;
                    $sets[] = $db->quoteName('es_birthdate') . '=' . $db->quote($newDate);
                } else {
                    //$this->error = 'DATE OF BIRTH:Invalid date format "'.$xlsRow[$this->labelIndexes['PASSPORT №']].' - ' . $xlsRow[$this->labelIndexes['DATE OF BIRTH']] . '" or month abbreviation.';
                    //return false;
                }
            }
        }

        if ($passportRow['es_gender'] === null) {
            $gender = strtolower($xlsRow[$this->labelIndexes['SEX (Eng.)']]);
            $passportRow['es_gender'] = ($gender == 'm' ? '1' : '2');
            $sets[] = $db->quoteName('es_gender') . '=' . ($gender == 'm' ? '1' : '2');
        }

        if ($passportRow['es_issueauthority'] === null) {

            if (isset($this->labelIndexes['PASS ISSUED BY'])) {
                if ($this->labelIndexes['PASS ISSUED BY'] !== null) {
                    $AuthorityName = $xlsRow[$this->labelIndexes['PASS ISSUED BY']];
                    $AuthorityID = getAuthorityIDOrAddTheRecord($AuthorityName, $countryID);
                    if ($AuthorityID !== null) {
                        $passportRow['es_issueauthority'] = $AuthorityID;
                        $sets[] = $db->quoteName('es_issueauthority') . '=' . $AuthorityID;
                    }
                }
            }
        }

        if ($passportRow['es_birthplace'] === null) {
            $Place_of_birth = $xlsRow[$this->labelIndexes['PL. OF BIRTH']];
            $Place_of_birthRIS = $xlsRow[$this->labelIndexes['PL. OF BIRTH'] + 1];
            $Place_of_birthID = $this->findPlaceByName($Place_of_birth, $countryID, $Place_of_birthRIS);
            if ($Place_of_birthID !== null) {
                $passportRow['es_birthplace'] = $Place_of_birthID;
                $sets[] = $db->quoteName('es_birthplace') . '=' . $Place_of_birthID;
            }
        }

        if ($passportRow['es_residenceplace'] === null) {
            $residencePlace = $xlsRow[$this->labelIndexes['PL. OF RESIDENCE']];
            $residencePlaceRUS = $xlsRow[$this->labelIndexes['PL. OF RESIDENCE'] + 1];
            $residencePlaceID = $this->findPlaceByName($residencePlace, $countryID, $residencePlaceRUS);

            if ($residencePlaceID !== null) {
                $passportRow['es_residenceplace'] = $residencePlaceID;
                $sets[] = $db->quoteName('es_residenceplace') . '=' . $residencePlaceID;
            }
        }

        if (count($sets) > 0) {
            $sets[] = 'es_changedate=NOW()';
            $query = 'UPDATE h82im_customtables_table_passports SET ' . implode(', ', $sets) . ' WHERE id=' . $passportRow['id'];
            $db->setQuery($query);
            $db->execute();
        }

        echo 'connect2Person<br/>';

        if (connect2Person($passportRow))
            $personAdded = true;

        return true;
    }

    function findCountryByName(string $name): ?int
    {
        $db = Factory::getDBO();
        $sql = 'SELECT id FROM h82im_customtables_table_countries WHERE'
            . ' es_namerussubj=' . $db->quote($name)
            . ' OR es_snamerussubj=' . $db->quote($name)
            . ' OR es_snamerusgen=' . $db->quote($name);

        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0)
            return null;

        return $rows[0]['id'];
    }

    function findPlaceByName(string $name, int $countryId, ?string $nameRus): ?int
    {
        $db = Factory::getDBO();
        $sql = 'SELECT id FROM #__customtables_table_placescities WHERE es_namelat=' . $db->quote($name);
        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0) {
            $sets = [];
            $sets[] = 'es_namelat=' . $db->quote($name);

            if ($nameRus !== null)
                $sets[] = 'es_namerussubj=' . $db->quote($nameRus);

            $sets[] = 'es_country=' . $countryId;
            $query = 'INSERT #__customtables_table_placescities SET ' . implode(', ', $sets);
            $db->setQuery($query);
            $db->execute();
            return $db->insertid();
        }
        return $rows[0]['id'];
    }

    function addPassport(array $xlsRow, bool &$personAdded): ?array
    {
        $db = Factory::getDBO();
        $sets = [];
        $sets[] = 'es_dbentrydate=NOW()';
        $sets[] = $db->quoteName('es_type') . '=3';
        $query = 'INSERT #__customtables_table_passports SET ' . implode(',', $sets);
        $db->setQuery($query);
        $db->execute();
        $id = $db->insertid();

        $query = 'SELECT *, published AS listing_published FROM #__customtables_table_passports WHERE id=' . $id . ' LIMIT 1';
        $db->setQuery($query);
        $recs = $db->loadAssocList();
        if (count($recs) == 0) {
            $this->error = 'Something terribly wrong.';
            return null;
        }
        $passportRow = $recs[0];
        echo 'Passport added trying to update the data<br/>';
        $this->updatePassport($passportRow, $xlsRow, $personAdded);


        $query = 'SELECT *, published AS listing_published FROM #__customtables_table_passports WHERE id=' . $id . ' LIMIT 1';
        $db->setQuery($query);
        $recs = $db->loadAssocList();
        if (count($recs) == 0) {
            $this->error = 'Something terribly wrong.';
            return null;
        }

        return $recs[0];
    }

    function findVisaByPersonId(int $personId, string $dateOfEntry): ?array
    {
        $db = Factory::getDBO();
        $sql = 'SELECT * FROM h82im_customtables_table_peoplesrussianvisas WHERE es_person=' . $personId . ' AND es_issuedate=' . $db->quote($dateOfEntry);
        $db->setQuery($sql);
        $rows = $db->loadAssocList();

        if (count($rows) == 0)
            return null;

        return $rows[0];
    }

    function addVisa(array $passportRow, array $xlsRow): bool
    {
        $personId = $passportRow['es_person'];
        $db = Factory::getDBO();
        $sets = [];

        $sets[] = 'es_person=' . $personId;
        $sets[] = 'es_passport=' . $passportRow['id'];
        $sets[] = 'es_dbentrydate=NOW()';
        $sets[] = 'es_changedate=NOW()';

        $dateOfEntry = CronAPP::convertDate($xlsRow[$this->labelIndexes['DATE OF ENTRY']]);
        $sets[] = 'es_issuedate=' . $db->quote($dateOfEntry);

        $query = 'INSERT #__customtables_table_peoplesrussianvisas SET ' . implode(', ', $sets);
        $db->setQuery($query);
        $db->execute();
        $id = $db->insertid();

        $query = 'SELECT *, published AS listing_published FROM #__customtables_table_peoplesrussianvisas WHERE id=' . $id . ' LIMIT 1';
        $db->setQuery($query);
        $recs = $db->loadAssocList();
        if (count($recs) == 0) {
            $this->error = 'Something terribly wrong.';
            return false;
        }
        $visaRow = $recs[0];
        $this->updateVisa($visaRow, $xlsRow);
        return true;
    }

    function updateVisa(array $visaRow, array $xlsRow): bool
    {
        $db = Factory::getDBO();
        $sets = [];

        if ($this->version == "EY") {
            $index = CronAPP::getColumnIndex('EW');
            $visaIssueCountry = $xlsRow[$index];
        } else {
            $visaIssueCountry = $xlsRow[$this->labelIndexes['PL. OF VISA COUNTRY']];
        }

        if ($visaIssueCountry !== null and $visaIssueCountry != "") {
            $countryID = $this->findCountryByName($visaIssueCountry);
            if ($countryID === null) {
                CronAPP::print_console('PL. OF VISA COUNTRY: ' . $visaIssueCountry . '<br/>', $this->logFile);
                $this->error = 'PL. OF VISA COUNTRY: ' . $visaIssueCountry;
                return false;
            }
        } else {
            $countryID = null;
        }

        if (isset($this->labelIndexes['PL. OF VISA CITY'])) {
            if (isset($xlsRow[$this->labelIndexes['PL. OF VISA CITY']])) {
                $visaIssuePlace = $xlsRow[$this->labelIndexes['PL. OF VISA CITY']];
                if ($visaIssuePlace !== null and $visaIssuePlace != "") {
                    $visaIssuePlaceRUS = $xlsRow[$this->labelIndexes['PL. OF VISA CITY'] + 1];

                    if ($visaIssuePlace !== null and $visaIssuePlace != "") {
                        $placeID = $this->findPlaceByName($visaIssuePlace, $countryID, $visaIssuePlaceRUS);
                        if ($placeID === null) {
                            CronAPP::print_console('PL. OF VISA CITY: ' . $visaIssuePlace . '<br/>', $this->logFile);
                            $this->error = 'PL. OF VISA CITY: ' . $visaIssuePlace;
                            return false;
                        }
                    }
                }
            }
        }

        if (isset($xlsRow[$this->labelIndexes['VISA MULTIPLICITY']])) {
            $visaMultiplicity = $xlsRow[$this->labelIndexes['VISA MULTIPLICITY']];

            if ($visaMultiplicity != "") {
                if ($visaMultiplicity == 'Многократная (до 12 месяцев)') {
                    $visaMultiplicityId = 3;
                } elseif ($visaMultiplicity == 'Двукратная (до 3 месяцев)') {
                    $visaMultiplicityId = 2;
                } elseif ($visaMultiplicity == 'Однократная (до 3 месяцев)') {
                    $visaMultiplicityId = 1;
                } else {
                    CronAPP::print_console('UNKNOWN VISA MULTIPLICITY: ' . $visaMultiplicity . '<br/>', $this->logFile);
                    $this->error = 'UNKNOWN VISA MULTIPLICITY: ' . $visaMultiplicity;
                    return false;
                }

                if ($visaRow['es_multiplicity'] === null) {
                    $sets[] = 'es_multiplicity=' . $visaMultiplicityId;
                } else {
                    if ($visaRow['es_multiplicity'] != $visaMultiplicityId) {
                        print_r($visaRow);
                        echo '$visaMultiplicityId=' . $visaMultiplicityId . '<br/>';
                        die('$visaRow[es_multiplicity] === $visaMultiplicityId');
                    }
                }
            }
        }

        //$visaPeriod = $xlsRow[$this->labelIndexes['VISA PERIOD']];
        $dateOfEntry = CronAPP::convertDate($xlsRow[$this->labelIndexes['DATE OF ENTRY']]);

        if ($visaRow['es_issuedate'] === null) {
            $sets[] = 'es_issuedate=' . $db->quote($dateOfEntry);
        } else {
            if ($visaRow['es_issuedate'] != $dateOfEntry) {
                print_r($visaRow);
                echo '$dateOfEntry=' . $dateOfEntry . '<br/>';
                die('$visaRow[es_issuedate] === $dateOfEntry');
            }
        }

        $dateOfExit = CronAPP::convertDate($xlsRow[$this->labelIndexes['DATE OF EXIT']]);
        if ($dateOfExit !== null and $dateOfExit != "") {
            if ($visaRow['es_visaenddate'] === null) {
                $sets[] = 'es_visaenddate=' . $db->quote($dateOfExit);
            } else {
                if ($visaRow['es_visaenddate'] != $dateOfExit) {
                    print_r($visaRow);
                    echo '$dateOfExit=' . $dateOfExit . '<br/>';
                    die('$visaRow[es_visaenddate] === $dateOfExit');
                }
            }
        }

        if (isset($xlsRow[$this->labelIndexes['COMPANY']])) {
            $workCompany = $xlsRow[$this->labelIndexes['COMPANY']];
            if ($workCompany !== null and $workCompany != "") {

                if (!in_array($workCompany, $this->workCompanies))
                    $this->workCompanies[] = $workCompany;

                echo '$workCompany=' . $workCompany . '<br/>';

                $companyID = $this->addCompany($workCompany, $visaRow['es_person'], true, $xlsRow);
                if ($companyID === null)
                    die;
            }
        }

        if (isset($xlsRow[$this->labelIndexes['INVITING COMPANY']])) {
            $invitingCompany = $xlsRow[$this->labelIndexes['INVITING COMPANY']];
            if ($invitingCompany !== null and $invitingCompany != "") {

                if (!in_array($invitingCompany, $this->invitingCompanies))
                    $this->invitingCompanies[] = $invitingCompany;

                $companyID = $this->addCompany($invitingCompany, $visaRow['es_person'], true, $xlsRow);
                if ($companyID === null)
                    die;

                if ($visaRow['es_invcompanyname'] === null) {
                    $sets[] = 'es_invcompanyname=' . $companyID;
                } else {
                    if ($visaRow['es_invcompanyname'] != $companyID) {
                        print_r($visaRow);
                        echo '$companyID=' . $companyID . '<br/>';
                        die('$visaRow[es_invcompanyname] !== $companyID');
                    }
                }

                $projectName = $xlsRow[$this->labelIndexes['PROJECT']];
                if ($projectName !== null and $projectName != '') {
                    $vesselName = $xlsRow[$this->labelIndexes['VESSEL']] ?? null;
                    if ($vesselName == '')
                        $vesselName = null;

                    if (!in_array($projectName, $this->numberofprojects))
                        $this->numberofprojects[] = $projectName;

                    $this->addProject($projectName, $companyID, $vesselName);
                }
            }
        }
        $placeOfStayDetailsID = $this->findPlaceOfStayByName($xlsRow);

        if ($placeOfStayDetailsID !== null) {
            if ($visaRow['es_stayplace'] === null) {
                $sets[] = 'es_stayplace=' . $placeOfStayDetailsID;
            } else {
                if ($visaRow['es_stayplace'] != $placeOfStayDetailsID) {
                    print_r($visaRow);
                    echo '$placeOfStayDetailsID=' . $placeOfStayDetailsID . '<br/>';
                    die('$visaRow[es_stayplace] === $placeOfStayDetailsID');
                }
            }
        }

        if (count($sets) > 0) {
            $sets[] = 'es_changedate=NOW()';
            $query = 'UPDATE #__customtables_table_peoplesrussianvisas SET ' . implode(', ', $sets) . ' WHERE id=' . $visaRow['id'];
            echo $query;
            $db->setQuery($query);
            $db->execute();
            return true;
        }

        return false;
    }

    function addCompany($companyName, int $personId, bool $isMigrant, $xlsRow): ?int
    {
        if ($companyName !== null) {

            $companyID = $this->findCompanyByName($companyName);
            echo '$companyID=' . $companyID . '<br/>';

            if ($companyID === null) {
                CronAPP::print_console('Inviting or Work Company: ' . $companyName . ' not found.<br/>', $this->logFile);
                die('Unknown Company "' . $companyName . '" not found.');
            }

            $companyEmployeeId = $this->addCompanyEmployee($companyID, $personId, $isMigrant, $xlsRow);
            if ($companyEmployeeId === null)
                return null;

            return $companyID;
        }
        return null;
    }

    function findCompanyByName(string $name): ?int
    {
        $db = Factory::getDBO();

        $name = str_replace('"', '', $name);
        $name = str_replace('«', '', $name);
        $name = str_replace('»', '', $name);
        $where = [];
        $where [] = 'REPLACE(REPLACE(es_fullnamerus,"»",""),"«","")=' . $db->quote($name);
        $where [] = 'REPLACE(REPLACE(es_shortnamerus,"»",""),"«","")=' . $db->quote($name);

        $sql = 'SELECT id FROM #__customtables_table_companies WHERE  ' . implode(' OR ', $where);
        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0)
            return null;

        $row = $rows[0];
        return $row['id'];
    }

    function addCompanyEmployee($CompanyID, $personID, bool $isMigrant, $xlsRow): ?int
    {
        $positionId = $this->findPositionByName($xlsRow);

        $db = Factory::getDBO();
        //AND es_ismigrant=1
        $sql = 'SELECT * FROM #__customtables_table_companyemployees WHERE es_company=' . $CompanyID . ' AND es_person=' . $personID . ' LIMIT 1';

        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0) {
            //Add New Company Employee
            $sets[] = 'es_company=' . $CompanyID;
            $sets[] = 'es_person=' . $personID;
            $sets[] = 'es_position=' . $positionId;
            $sets[] = 'es_ismigrant=' . $isMigrant;

            $query = 'INSERT #__customtables_table_companyemployees SET ' . implode(', ', $sets);
            $db->setQuery($query);
            $db->execute();
            return $db->insertid();
        } else {
            //Update
            $sets = [];
            $row = $rows[0];
            if ($row['es_position'] === null) {
                $sets[] = 'es_position=' . $positionId;
                $sets[] = 'es_ismigrant=' . $isMigrant;
            } else {
                if ($row['es_position'] != $positionId) {
                    /*
                    echo $sql;
                    echo '<br/>$positionId=' . $positionId . '<br/>';
                    print_r($row);
                    die;
                    */

                    //Add New Company Employee
                    $sets[] = 'es_company=' . $CompanyID;
                    $sets[] = 'es_person=' . $personID;
                    $sets[] = 'es_position=' . $positionId;
                    $sets[] = 'es_ismigrant=' . $isMigrant;

                    $query = 'INSERT #__customtables_table_companyemployees SET ' . implode(', ', $sets);
                    $db->setQuery($query);
                    $db->execute();
                    return $db->insertid();
                }
            }

            if (count($sets) > 0) {
                $query = 'UPDATE #__customtables_table_companyemployees SET ' . implode(', ', $sets) . ' WHERE id=' . $row['id'];
                $db->setQuery($query);
                $db->execute();
            }
            return $row['id'];
        }
    }

    function findPositionByName($xlsRow): ?int
    {
        $name = trim($xlsRow[$this->labelIndexes['JOB POSITION Eng']]);
        $db = Factory::getDBO();

        $sql = 'SELECT id FROM #__customtables_table_positions WHERE '
            . 'LOWER(es_namelat)=' . $db->quote(mb_strtolower($name, 'UTF-8')) . ' OR '
            . 'LOWER(es_namerussubj)=' . $db->quote(mb_strtolower($name, 'UTF-8')) . ' '
            . 'LIMIT 1';

        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0) {
            CronAPP::print_console('Position: "' . $name . '" not found. Added.<br/>', $this->logFile);
            $sets = [];
            $sets[] = 'es_namelat=' . $db->quote($name);
            $sets[] = 'es_namerussubj=' . $db->quote(trim($xlsRow[$this->labelIndexes['JOB POSITION Eng'] + 1]));

            $query = 'INSERT #__customtables_table_positions SET ' . implode(', ', $sets);
            $db->setQuery($query);
            $db->execute();
            return $db->insertid();
        }
        $row = $rows[0];
        return $row['id'];
    }

    function addProject(string $projectName, int $companyID, ?string $vesselName)
    {
        $db = Factory::getDBO();
        $sql = 'SELECT * FROM #__customtables_table_migprojects WHERE '
            . 'LOWER(es_name)=' . $db->quote($projectName) . ' '
            . 'LIMIT 1';

        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        $sets = [];

        if (count($rows) == 0) {

            $sets[] = 'es_name=' . $db->quote($projectName);
            $sets[] = 'es_company=' . $companyID;

            if ($vesselName !== null)
                $sets[] = 'es_location=' . $db->quote($vesselName);

            $query = 'INSERT #__customtables_table_migprojects SET ' . implode(', ', $sets);
            $db->setQuery($query);
            $db->execute();
            $projectID = $db->insertid();

            $sql = 'SELECT * FROM #__customtables_table_migprojects WHERE id=' . $projectID . ' LIMIT 1';
            $db->setQuery($sql);
            $rows = $db->loadAssocList();
        }

        $row = $rows[0];
        if (($row['es_location'] === null or $row['es_location'] == '') and $vesselName !== null)
            $sets[] = 'es_location=' . $db->quote($vesselName);

        if (count($sets) > 0) {
            $query = 'UPDATE #__customtables_table_migprojects SET ' . implode(', ', $sets) . ' WHERE id=' . $row['id'];
            $db->setQuery($query);
            $db->execute();
        }
        return $row['id'];
    }

    function findPlaceOfStayByName($xlsRow): ?int
    {
        $db = Factory::getDBO();
        $placeOfStayDetails = null;

        if (isset($this->labelIndexes['PL OF STAY DETAILS'])) {
            if (isset($xlsRow[$this->labelIndexes['PL OF STAY DETAILS']]))
                $placeOfStayDetails = $xlsRow[$this->labelIndexes['PL OF STAY DETAILS']];
        }

        if ($placeOfStayDetails !== null and $placeOfStayDetails !== '') {
            $sql = 'SELECT id FROM #__customtables_table_stayplaces WHERE es_comment=' . $db->quote($placeOfStayDetails);
        } else {
            $fields = ['PL OF STAY REGION',
                'TYPE PL OF STAY',
                'PL OF STAY CITY',
                'TYPE PL OF STAY DISTRICT',
                'PL OF STAY DISTRICT',
                'TYPE PL OF STAY STREET',
                'PL OF STAY STREET',
                'TYPE PL OF STAY HOUSE',
                'PL OF STAY HOUSE',
                'PL OF STAY HOUSING',
                'PL OF STAY BUILDING',
                'PL OF STAY FLAT'];

            $comments = [];
            foreach ($fields as $field) {

                if (isset($this->labelIndexes[$field])) {

                    $value = null;

                    if (isset($xlsRow[$this->labelIndexes[$field]]))
                        $value = $xlsRow[$this->labelIndexes[$field]];

                    if ($value !== null and $value != "")
                        $comments[] = $xlsRow[$this->labelIndexes[$field]];
                }
            }

            $commentString = implode(',', $comments);
            if ($commentString == '')
                return null;

            $sql = 'SELECT id FROM #__customtables_table_stayplaces WHERE es_comment=' . $db->quote($commentString);
        }

        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        if (count($rows) == 0)
            return null;

        $row = $rows[0];
        return $row['id'];
    }

    function getCellByName(array $xlsRow, string $columnName)
    {
        $index = CronAPP::getColumnIndex($columnName);

        if (isset($xlsRow[$index]))
            return $xlsRow[$index];

        return null;
    }
}