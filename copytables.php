<?php
$servername = "localhost";
$username = "root";
$password = "";

$tables = ['h82im_customtables_categories', 'h82im_customtables_fields', 'h82im_customtables_layouts', 'h82im_customtables_tables', 'h82im_menu',
    'h82im_customtables_table_workhours'];

truncateTables($servername, $username, $password,$tables);
copyTables($servername, $username, $password,$tables);
echo '<br/>';
echo 'DROP TABLE `h82im_customtables_categories`, `h82im_customtables_fields`, `h82im_customtables_layouts`, `h82im_customtables_tables`, `h82im_menu`;';
echo '<br/>';

function copyTable($servername, $username, $password, $tableName)
{
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = 'INSERT INTO `lwsp-ct`.`' . $tableName . '` SELECT * from `lwsp`.`' . $tableName . '`';
    $result = $conn->query($query);

    echo 'Table "' . $tableName . '" copied<br/>';
}

function copyTables($servername, $username, $password,$tables)

{
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($tables as $table) {
        copyTable($servername, $username, $password, $table);
    }
    echo "Tables copied<br/>";
}

function truncateTables($servername, $username, $password,$tables)
{
    $dbname = "lwsp-ct";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = 'TRUNCATE TABLE `'.implode('`,`',$tables).'`;';
    $result = $conn->query($query);

    echo "Tables truncated<br/>";
}