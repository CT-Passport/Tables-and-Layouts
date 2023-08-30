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

function cron_1_xls_file($logFile)
{
    require_once 'vendor/autoload.php';

    //01_SK_NORTH BAY_20122020
    //CronAPP::print_console(' - Check passports.<br/>',$logFile);
    //checkPassports('1.xlsx');
    CronAPP::print_console(' - Check name translations.<br/>',$logFile);
    checkTranslationsNames('1.xlsx',$logFile);
	CronAPP::print_console(' - Check last name translations.<br/>',$logFile);
    checkTranslationsLastNames('1.xlsx',$logFile);
    CronAPP::print_console(' - Check places translations.<br/>',$logFile);
    checkTranslationsPlaces('1.xlsx',$logFile);
}

function checkTranslationsPlaces($filePath,$logFile)
{
    $table = 'h82im_customtables_table_translationsplaces';
    $rows = getRowValues($filePath, 'Chinese_places', '0');

    foreach ($rows as $row) {
        if (isset($row[0]) and isset($row[1]))
            insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1],$logFile);
    }
    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>',$logFile);

    $sql = 'UPDATE h82im_customtables_table_placescities'
        . ' SET es_namerussubj='
        . ' (SELECT h82im_customtables_table_translationsplaces.es_namerus'
        . ' FROM h82im_customtables_table_translationsplaces WHERE LOWER(h82im_customtables_table_translationsplaces.es_namelat)=LOWER(h82im_customtables_table_placescities.es_namelat) LIMIT 1)'
        . ' WHERE h82im_customtables_table_placescities.es_namerussubj IS NULL OR h82im_customtables_table_placescities.es_namerussubj=""';

    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();
}

function checkTranslationsLastNames($filePath,$logFile)
{
    $table = 'h82im_customtables_table_translationslastnames';
    $rows = getRowValues($filePath, 'Chinese_last_names', '0');

    foreach ($rows as $row) {
        insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1],$logFile);
    }

    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>',$logFile);

    $sql = 'UPDATE h82im_customtables_table_people'
        . ' SET es_lastnamerussubj='
        . ' (SELECT h82im_customtables_table_translationslastnames.es_namerus'
        . ' FROM h82im_customtables_table_translationslastnames WHERE LOWER(h82im_customtables_table_translationslastnames.es_namelat)=LOWER(h82im_customtables_table_people.es_lastnamelat) LIMIT 1)'
        . ' WHERE es_lastnamerussubj IS NULL OR es_lastnamerussubj=""';

    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();
}

function checkTranslationsNames($filePath,$logFile)
{
    $table = 'h82im_customtables_table_translationsnames';
    $rows = getRowValues($filePath, 'Chinese_names', '0');
    $db = Factory::getDBO();

    foreach ($rows as $row) {
        if (isset($row[0]) and isset($row[1])) {
            insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1],$logFile);
        }
    }

    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>',$logFile);

    $sql = 'SELECT id, es_firstnamelat FROM h82im_customtables_table_people WHERE es_firstnamerussubj IS NULL OR es_firstnamerussubj=""';
    $db->setQuery($sql);
    $db->execute();

    if ($db->getNumRows() == 0) {
        return;
    }

    $rows = $db->loadAssocList();
    foreach ($rows as $row){
        CronAPP::print_console(' -- id: ' . $row["id"] . ' - Name: ' . $row["es_firstnamelat"] . '<br>',$logFile);

        $nameLat = $row["es_firstnamelat"];
        $translatedName = findNamePart($nameLat);
        if ($translatedName == null) {
            $parts = explode(' ', $nameLat);
            $name = [];
            foreach ($parts as $part) {
                $namePartRus = findNamePart($part);
                if ($namePartRus != null)
                    $name[] = $namePartRus;
                else
                    $name[] = $part;
            }
            $translatedName = implode(' ', $name);
        }

        if ($nameLat !== $translatedName) {
            CronAPP::print_console(' -- New translated name: ' . $translatedName . '<br/>',$logFile);

            $sql = 'UPDATE h82im_customtables_table_people'
                . ' SET es_firstnamerussubj="' . $translatedName . '"'
                . ' WHERE id=' . $row["id"];

            CronAPP::print_console(' -- '.$sql.'<br/>',$logFile);

            $db = Factory::getDBO();
            $db->setQuery($sql);
            $db->execute();
        }
    }
}

function findNamePart($namePart)
{
    $sql = 'SELECT es_namerus FROM h82im_customtables_table_translationsnames WHERE es_namelat="' . $namePart . '" LIMIT 1';
    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();

    if ($db->getNumRows == 0) {
        return null;
    }

    $row = $db->loadAssoc();
    return $row['es_namerus'];
}

function insertIfNotFound($table, $column1, $column2, $value1, $value2,$logFile)
{
    if (trim($value1) != '' and trim($value2) != "") {
        if (!checkIfExists($table, $column1, trim($value1))) {
            $query = 'INSERT INTO ' . $table . ' (' . $column1 . ',' . $column2 . ') VALUES ("' . trim($value1) . '","' . trim($value2) . '");';
            CronAPP::print_console(' -- '. $query . '<br/>',$logFile);

            $db = Factory::getDBO();
            $db->setQuery($query);
            $db->execute();
        }
    }
}

function checkIfExists($table, $column1, $value1)
{
    $sql = "SELECT id FROM " . $table . " WHERE " . $column1 . '="' . $value1 . '" LIMIT 1';
    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();

    if ($db->getNumRows() == 0) {
        return false;
    }
    return true;
}

function checkPassports($filePath)
{
    $rows = getRowValues($filePath, 'Pass_data_check', '0');
    print_r($rows);
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
                if ($value == $stopCol1Value or $value == '')
                    break;

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



