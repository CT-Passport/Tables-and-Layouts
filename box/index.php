<?php

require_once 'vendor/autoload.php';
require_once 'db.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
connectDB();

//01_SK_NORTH BAY_20122020
//checkPassports('1.xlsx');
//checkTranslationsNames('1.xlsx');
//checkTranslationsLastNames('1.xlsx');
checkTranslationsPlaces('1.xlsx');

function checkTranslationsPlaces($filePath)
{
    $table = 'h82im_customtables_table_translationsplaces';
    $rows = getRowValues($filePath, 'Chinese_places', '0');
    $conn = new mysqli(servername, username, password, database);

    foreach ($rows as $row) {
        if(isset($row[0]) and isset($row[1]))
            insertIfNotFound($conn, $table, 'es_namelat', 'es_namerus', $row[0], $row[1]);
    }

    echo 'Table "' . $table . '" records added<br/>';

    $sql = 'UPDATE h82im_customtables_table_placescities'
        . ' SET es_namerussubj='
        . ' (SELECT h82im_customtables_table_translationsplaces.es_namerus'
        . ' FROM h82im_customtables_table_translationsplaces WHERE LOWER(h82im_customtables_table_translationsplaces.es_namelat)=LOWER(h82im_customtables_table_placescities.es_namelat) LIMIT 1)'
        . ' WHERE h82im_customtables_table_placescities.es_namerussubj IS NULL OR h82im_customtables_table_placescities.es_namerussubj=""';
    $result = $conn->query($sql);

    $conn->close();
}

function checkTranslationsLastNames($filePath)
{
    $table = 'h82im_customtables_table_translationslastnames';
    $rows = getRowValues($filePath, 'Chinese_last_names', '0');
    $conn = new mysqli(servername, username, password, database);

    foreach ($rows as $row) {
        insertIfNotFound($conn, $table, 'es_namelat', 'es_namerus', $row[0], $row[1]);
    }

    echo 'Table "' . $table . '" records added<br/>';

    $sql = 'UPDATE h82im_customtables_table_people'
        . ' SET es_lastnamerussubj='
        . ' (SELECT h82im_customtables_table_translationslastnames.es_namerus'
        . ' FROM h82im_customtables_table_translationslastnames WHERE LOWER(h82im_customtables_table_translationslastnames.es_namelat)=LOWER(h82im_customtables_table_people.es_lastnamelat) LIMIT 1)'
        . ' WHERE es_lastnamerussubj IS NULL OR es_lastnamerussubj=""';

    $result = $conn->query($sql);
    $conn->close();
}

function checkTranslationsNames($filePath)
{
    $table = 'h82im_customtables_table_translationsnames';
    $rows = getRowValues($filePath, 'Chinese_names', '0');
    $conn = new mysqli(servername, username, password, database);

    foreach ($rows as $row) {
        if (isset($row[0]) and isset($row[1])) {
            insertIfNotFound($conn, $table, 'es_namelat', 'es_namerus', $row[0], $row[1]);
        }
    }
    echo 'Table "' . $table . '" records added<br/>';

    $sql = 'SELECT id, es_firstnamelat FROM h82im_customtables_table_people WHERE es_firstnamerussubj IS NULL OR es_firstnamerussubj=""';
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        $conn->close();
        return;
    }

    while ($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"] . " - Name: " . $row["es_firstnamelat"] . "<br>";

        $nameLat = $row["es_firstnamelat"];
        $translatedName = findNamePart($conn, $nameLat);
        if ($translatedName == null) {
            $parts = explode(' ', $nameLat);
            $name = [];
            foreach ($parts as $part) {
                $namePartRus = findNamePart($conn, $part);
                if ($namePartRus != null)
                    $name[] = $namePartRus;
                else
                    $name[] = $part;
            }
            $translatedName = implode(' ', $name);
        }

        if ($nameLat !== $translatedName) {
            echo 'New translated name: ' . $translatedName . '<br/>';

            $sql = 'UPDATE h82im_customtables_table_people'
                . ' SET es_firstnamerussubj="' . $translatedName . '"'
                . ' WHERE id=' . $row["id"];
            echo $sql;

            $conn->query($sql);
        }
    }
    $conn->close();
}

function findNamePart($conn, $namePart)
{
    $sql = 'SELECT es_namerus FROM h82im_customtables_table_translationsnames WHERE es_namelat="' . $namePart . '" LIMIT 1';
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['es_namerus'];
}

function insertIfNotFound($conn, $table, $column1, $column2, $value1, $value2)
{
    if (trim($value1) != '' and trim($value2) != "") {
        if (!checkIfExists($conn, $table, $column1, trim($value1))) {
            $query = 'INSERT INTO ' . $table . ' (' . $column1 . ',' . $column2 . ') VALUES ("' . trim($value1) . '","' . trim($value2) . '");';
            echo $query . '<br/>';
            $result = $conn->query($query);
        }
    }
}

function checkIfExists($conn, $table, $column1, $value1)
{
    $sql = "SELECT id FROM " . $table . " WHERE " . $column1 . '="' . $value1 . '" LIMIT 1';
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
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



