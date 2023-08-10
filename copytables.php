<?php
$servername = "localhost";
$username = "root";
$password = "";

truncateTables($servername, $username, $password);
copyTables($servername, $username, $password);
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

function copyTables($servername, $username, $password)

{
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $tables = ['h82im_customtables_categories', 'h82im_customtables_fields', 'h82im_customtables_layouts', 'h82im_customtables_tables', 'h82im_menu'];
    foreach ($tables as $table) {
        copyTable($servername, $username, $password, $table);
    }
    echo "Tables copied<br/>";
}

function truncateTables($servername, $username, $password)
{
    $dbname = "lwsp-ct";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = 'TRUNCATE TABLE `h82im_customtables_categories`, `h82im_customtables_fields`, `h82im_customtables_filebox_companies_compcontracts`, `h82im_customtables_filebox_companies_documents`, `h82im_customtables_filebox_companies_shared`, `h82im_customtables_filebox_contracts_files`, `h82im_customtables_filebox_migmvdlois_files`, `h82im_customtables_filebox_migmvdlois_folderlink`, `h82im_customtables_filebox_migmvdspeedupletters_speedletdocs`, `h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink`, `h82im_customtables_filebox_migprojectcases_files`, `h82im_customtables_filebox_migrelministryenqletters_docs`, `h82im_customtables_filebox_people_documents`, `h82im_customtables_gallery_workhours_images`, `h82im_customtables_layouts`, `h82im_customtables_log`, `h82im_customtables_options`, `h82im_customtables_tables`, `h82im_customtables_table_applications`, `h82im_customtables_table_capitalstatus`, `h82im_customtables_table_citizenshiptypes`, `h82im_customtables_table_companies`, `h82im_customtables_table_companyemployees`, `h82im_customtables_table_contracts`, `h82im_customtables_table_countries`, `h82im_customtables_table_currencies`, `h82im_customtables_table_developmentprogress`, `h82im_customtables_table_divtypes`, `h82im_customtables_table_documents`, `h82im_customtables_table_emp_id`, `h82im_customtables_table_eststat`, `h82im_customtables_table_ethnicity`, `h82im_customtables_table_genders`, `h82im_customtables_table_housetypes`, `h82im_customtables_table_housingtype`, `h82im_customtables_table_languages`, `h82im_customtables_table_migdocumentsmisc`, `h82im_customtables_table_migdocumentstypes`, `h82im_customtables_table_migmidcompanyloiletters`, `h82im_customtables_table_migmvdapplications`, `h82im_customtables_table_migmvdapplicationssub`, `h82im_customtables_table_migmvdcorrletters`, `h82im_customtables_table_migmvdemplists`, `h82im_customtables_table_migmvdguaranteeletters`, `h82im_customtables_table_migmvdloidocstatuses`, `h82im_customtables_table_migmvdlois`, `h82im_customtables_table_migmvdspeedupletters`, `h82im_customtables_table_migprojectbatches`, `h82im_customtables_table_migprojectcases`, `h82im_customtables_table_migprojectcoverletters`, `h82im_customtables_table_migprojects`, `h82im_customtables_table_migprojectsemployees`, `h82im_customtables_table_migprojectsites`, `h82im_customtables_table_migrelministryenqletterlist`, `h82im_customtables_table_migrelministryenqletters`, `h82im_customtables_table_migvisamultiplicityterm`, `h82im_customtables_table_migvisatypes`, `h82im_customtables_table_migvisitpurposes`, `h82im_customtables_table_passissueauthorities`, `h82im_customtables_table_passportprimarystatus`, `h82im_customtables_table_passporttypes`, `h82im_customtables_table_passvaliditystatus`, `h82im_customtables_table_people`, `h82im_customtables_table_peoplesrussianvisas`, `h82im_customtables_table_persontypes`, `h82im_customtables_table_placescities`, `h82im_customtables_table_positions`, `h82im_customtables_table_purposes`, `h82im_customtables_table_regions`, `h82im_customtables_table_rfconsulatestatus`, `h82im_customtables_table_stayplaces`, `h82im_customtables_table_staytypes`, `h82im_customtables_table_streettypes`, `h82im_customtables_table_testtable`, `h82im_customtables_table_type`, `h82im_customtables_table_typeofinnerpremisses`, `h82im_customtables_table_typeofpremisses`, `h82im_customtables_table_typesofdistrict`, `h82im_customtables_table_visas`, `h82im_customtables_table_visatypecategories`, `h82im_customtables_table_workers`, `h82im_customtables_table_workhours`, `h82im_customtables_table_worldregions`, `h82im_customtables_table_youtubegallerycategories`, `h82im_customtables_table_youtubegallerysettings`, `h82im_customtables_table_youtubegallerythemes`, `h82im_customtables_table_youtubegalleryvideolists`, `h82im_customtables_table_youtubegalleryvideos`, `h82im_menu`;';
    $result = $conn->query($query);

    echo "Tables truncated<br/>";
}