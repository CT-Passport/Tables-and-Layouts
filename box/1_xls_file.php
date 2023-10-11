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
use PhpOffice\PhpSpreadsheet\IOFactory;

function cron_1_xls_file($logFile, ?string $file)
{
    unpublishUnreadableFiles();
    findXlSFiles();

    if($file=== null)
        return;
    
    require_once 'vendor/autoload.php';

    $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $file;
    CronAPP::print_console(' - Check name translations.<br/>', $logFile);
    checkTranslationsNames($filePath, $logFile);
    CronAPP::print_console(' - Check last name translations.<br/>', $logFile);
    checkTranslationsLastNames($filePath, $logFile);
    CronAPP::print_console(' - Check places translations.<br/>', $logFile);
    checkTranslationsPlaces($filePath, $logFile);
}

function findXlSFiles()
{
    $files =boxFindFilesByExtension(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'documents', 'xls');
    require_once 'PhpOffice/vendor/autoload.php';

    foreach ($files as $file)
    {
        $fileNameParts = explode('.',$file);
        $fileNameParts[count($fileNameParts)-1]='xlsx';
        $XLSXFileName = implode('.',$fileNameParts);

        if(!file_exists($XLSXFileName))
        {
            $objPHPExcel = IOFactory::load($file);
            $objWriter = IOFactory::createWriter($objPHPExcel,'Xlsx');
            $objWriter->save($XLSXFileName);
            echo 'New file: '.$XLSXFileName.'<br/>';
        }
    }
}

function boxFindFilesByExtension($directory, $extension)
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        $filename = $item->getFilename();

        if ($item->isFile()) {
            $nameParts = explode('.', $filename);
            if (end($nameParts) == $extension and !in_array($item->getPath() . DIRECTORY_SEPARATOR . $filename, $files)) {

                if ($filename[0] != '~')
                    $files[] = $item->getPath() . DIRECTORY_SEPARATOR . $filename;
            }
        }
    }

    return $files;
}

function unpublishUnreadableFiles()
{
    $db = Factory::getDBO();
    $db->setQuery('update `#__customtables_table_excelfiles` set published = 0 where es_version = "-1" or es_version = "97";');
    $db->execute();
}

function checkTranslationsPlaces($filePath, $logFile)
{
    $table = 'h82im_customtables_table_translationsplaces';
    $rows = getRowValues($filePath, 'Chinese_places', '0');

    foreach ($rows as $row) {
        if (isset($row[0]) and isset($row[1]))
            insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1], $logFile);
    }
    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>', $logFile);

    $sql = 'UPDATE h82im_customtables_table_placescities'
        . ' SET es_namerussubj='
        . ' (SELECT h82im_customtables_table_translationsplaces.es_namerus'
        . ' FROM h82im_customtables_table_translationsplaces WHERE LOWER(h82im_customtables_table_translationsplaces.es_namelat)=LOWER(h82im_customtables_table_placescities.es_namelat) LIMIT 1)'
        . ' WHERE h82im_customtables_table_placescities.es_namerussubj IS NULL OR h82im_customtables_table_placescities.es_namerussubj=""';

    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();
}

function checkTranslationsLastNames($filePath, $logFile)
{
    $table = 'h82im_customtables_table_translationslastnames';
    $rows = getRowValues($filePath, 'Chinese_last_names', '0');

    foreach ($rows as $row) {
        insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1], $logFile);
    }

    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>', $logFile);

    $sql = 'UPDATE h82im_customtables_table_people'
        . ' SET es_lastnamerussubj='
        . ' (SELECT h82im_customtables_table_translationslastnames.es_namerus'
        . ' FROM h82im_customtables_table_translationslastnames WHERE LOWER(h82im_customtables_table_translationslastnames.es_namelat)=LOWER(h82im_customtables_table_people.es_lastnamelat) LIMIT 1)'
        . ' WHERE es_lastnamerussubj IS NULL OR es_lastnamerussubj=""';

    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();
}

function checkTranslationsNames($filePath, $logFile)
{
    $table = 'h82im_customtables_table_translationsnames';
    $rows = getRowValues($filePath, 'Chinese_names', '0');
    $db = Factory::getDBO();

    foreach ($rows as $row) {
        if (isset($row[0]) and isset($row[1])) {
            insertIfNotFound($table, 'es_namelat', 'es_namerus', $row[0], $row[1], $logFile);
        }
    }

    CronAPP::print_console(' -- Table "' . $table . '" records added<br/>', $logFile);

    $sql = 'SELECT id, es_firstnamelat FROM h82im_customtables_table_people WHERE es_firstnamerussubj IS NULL OR es_firstnamerussubj=""';
    $db->setQuery($sql);
    $db->execute();

    if ($db->getNumRows() == 0) {
        return;
    }

    $rows = $db->loadAssocList();
    foreach ($rows as $row) {
        CronAPP::print_console(' -- id: ' . $row["id"] . ' - Name: ' . $row["es_firstnamelat"] . '<br>', $logFile);

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

        //echo 'Name in the record: '.$nameLat.', Translation: '.$translatedName;
        //if ($nameLat !== $translatedName) {
        CronAPP::print_console(' -- New translated name: ' . $translatedName . '<br/>', $logFile);

        $sql = 'UPDATE h82im_customtables_table_people'
            . ' SET es_firstnamerussubj="' . $translatedName . '"'
            . ' WHERE id=' . $row["id"];

        CronAPP::print_console(' -- ' . $sql . '<br/>', $logFile);

        $db = Factory::getDBO();
        $db->setQuery($sql);
        $db->execute();
        //}
    }
}

function findNamePart($namePart)
{
    $sql = 'SELECT es_namerus FROM h82im_customtables_table_translationsnames WHERE es_namelat="' . $namePart . '" LIMIT 1';
    $db = Factory::getDBO();
    $db->setQuery($sql);
    $db->execute();

    if ($db->getNumRows() == 0) {
        return null;
    }

    $row = $db->loadAssoc();
    return $row['es_namerus'];
}

function insertIfNotFound($table, $column1, $column2, $value1, $value2, $logFile)
{
    if (trim($value1) != '' and trim($value2) != "") {
        if (!checkIfExists($table, $column1, trim($value1))) {
            $query = 'INSERT INTO ' . $table . ' (' . $column1 . ',' . $column2 . ') VALUES ("' . trim($value1) . '","' . trim($value2) . '");';
            CronAPP::print_console(' -- ' . $query . '<br/>', $logFile);

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

function getRowValues($filePath, $sheetName, $stopCol1Value = ''): ?array
{
    $reader = ReaderEntityFactory::createReaderFromFile($filePath);
    $reader->open($filePath);
    $sheet = CronAPP::findSheet($reader, $sheetName);
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


