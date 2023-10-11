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
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

function ESCustom_xlsfile($row_new, $row_old)
{
    if (isset($row_new['id']) and (int)$row_new['listing_published'] == 1)
        updateFileRowDetails($row_new);

    addExistingFiles();
}

function addExistingFiles()
{
    $allXLSfiles = findFilesByExtension(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'documents', 'xlsx');
    $db = Factory::getDBO();

    foreach ($allXLSfiles as $fileNameAndPath) {

        $row = getFileRow($fileNameAndPath);

        if ($row === null) {
            $fileNameParts = explode(DIRECTORY_SEPARATOR, $fileNameAndPath);
            $fileName = cleanFileName(end($fileNameParts));
            $folder = str_replace($fileName, '', $fileNameAndPath);

            $sets = [];
            $sets[] = 'es_file=' . $db->quote(cleanFileName($fileName));
            $sets[] = 'es_folder=' . $db->quote($folder);
            $sets[] = 'es_comment=' . $db->quote('Added from Documents');
            $sets[] = 'es_uploaddate=NOW()';

            $query = 'INSERT #__customtables_table_excelfiles SET  ' . implode(',', $sets);
            $db->setQuery($query);
            $db->execute();
            $id = $db->insertid();
            copy($fileNameAndPath, JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $fileName);

            $query = 'SELECT * FROM #__customtables_table_excelfiles WHERE id= ' . $id . ' LIMIT 1';
            $db->setQuery($query);
            $recs = $db->loadAssocList();
            updateFileRowDetails($recs[0]);
        } else {
            //updateFileRowDetails($row);
        }
    }
}

function updateFileRowDetails($row)
{
    require_once 'box/vendor/autoload.php';
    require_once 'box/app.php';

    $db = JFactory::getDBO();

    $sets = [];

    if ($row['es_folder'] === null or $row['es_folder'] === '') {
        $folder = findFolder(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'documents', $row['es_file']);

        if ($folder !== null)
            $sets[] = 'es_folder=' . $db->quote($folder);

    }

    $fileNameParts = explode('.', $row['es_file']);

    $fileExtension = end($fileNameParts);
    if ($fileExtension == 'xlsx') {
        if ($row['es_version'] === null or $row['es_version'] === '') {

            $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $row['es_file'];
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);

            $version = CronAPP::findVersion($reader); //column "PL OF STAY DETAILS" name
            $sets[] = 'es_version=' . $db->quote($version);
        }
    } else
        $sets[] = 'es_version=' . $db->quote('97');

    if (count($sets) > 0) {
        $query = 'UPDATE #__customtables_table_excelfiles SET  ' . implode(',', $sets) . ' WHERE id = ' . $row['id'];
        $db->setQuery($query);
        $db->execute();
    }
}

function cleanFileName($fileName)
{
    //Clean Up file name
    $filename_raw = strtolower($fileName);
    $filename_raw = str_replace(' ', '_', $filename_raw);
    $filename_raw = str_replace('-', '_', $filename_raw);
    return preg_replace("/[^\p{L}\d._]/u", "", $filename_raw);
}

function getFileRow($fileNameAndPath)
{
    $fileNameParts = explode(DIRECTORY_SEPARATOR, $fileNameAndPath);
    $fileName = end($fileNameParts);
    $cleanFileName = cleanFileName($fileName);

    $db = Factory::getDBO();
    $query = 'SELECT * FROM #__customtables_table_excelfiles WHERE es_file= ' . $db->quote($cleanFileName) . ' LIMIT 1';
    $db->setQuery($query);
    $recs = $db->loadAssocList();
    if (count($recs) == 0)
        return null;

    return $recs[0];
}

function findFilesByExtension($directory, $extension)
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

function findFolderWithFile($directory, $filename2find)
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);

    foreach ($iterator as $item) {
        $cleanFileName = cleanFileName($item->getFilename());
        if ($item->isFile() && $filename2find == $cleanFileName) {
            return $item->getPath();
        }
    }
    return false;
}

function findFolder(string $path, string $fileName): ?string
{
    $filePath = findFolderWithFile($path, $fileName);
    if (!$filePath) {
        //echo 'File "' . $fileName . '" not found.';
        //die;
        return null;
    }
    return $filePath;
}
