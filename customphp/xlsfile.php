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
    if (isset($row_new['id']) and (int)$row_new['listing_published'] == 1) {
        require_once 'box/vendor/autoload.php';
        require_once 'box/app.php';

        $db = JFactory::getDBO();

        $sets = [];

        if ($row_new['es_folder'] === null or $row_new['es_folder'] === '') {
            $folder = findFolder(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'documents', $row_new['es_file']);

            if ($folder !== null)
                $sets[] = 'es_folder=' . $db->quote($folder);

        }

        $fileNameParts = explode('.', $row_new['es_file']);
        $fileExtension = end($fileNameParts);
        if ($fileExtension == 'xlsx') {
            if ($row_new['es_version'] === null or $row_new['es_version'] === '') {

                $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $row_new['es_file'];

                $reader = ReaderEntityFactory::createReaderFromFile($filePath);
                $reader->open($filePath);
                $version = CronAPP::findVersion($reader); //column "PL OF STAY DETAILS" name
                $sets[] = 'es_version=' . $db->quote($version);
            }
        } else
            $sets[] = 'es_version=' . $db->quote('97');

        if (count($sets) > 0) {
            $query = 'UPDATE #__customtables_table_excelfiles SET  ' . implode(',', $sets) . ' WHERE id = ' . $row_new['id'];
            $db->setQuery($query);
            $db->execute();
        }
    }

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
            $fileName = end($fileNameParts);
            $folder = str_replace($fileName, '', $fileNameAndPath);

            $sets = [];
            $sets[] = 'es_file=' . $db->quote($fileName);
            $sets[] = 'es_folder=' . $db->quote($folder);
            $sets[] = 'es_comment=' . $db->quote('Added from Documents');
            $sets[] = 'es_uploaddate=NOW()';

            $query = 'INSERT #__customtables_table_excelfiles SET  ' . implode(',', $sets);
            $db->setQuery($query);
            $db->execute();
            copy($fileNameAndPath, JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $fileName);
        }
    }
}

function getFileRow($fileName)
{
    $db = Factory::getDBO();
    $query = 'SELECT * FROM #__customtables_table_excelfiles WHERE es_file= ' . $db->quote($fileName) . ' LIMIT 1';
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


        //Clean Up file name
        $filename_raw = strtolower($item->getFilename());
        $filename_raw = str_replace(' ', '_', $filename_raw);
        $filename_raw = str_replace('-', '_', $filename_raw);
        //$filename = preg_replace("/[^a-z\d._]/", "", $filename_raw);
        $filename = preg_replace("/[^\p{L}\d._]/u", "", $filename_raw);

        if ($item->isFile() && $filename == $filename2find) {
            return $item->getPath();
        }
    }

    return false;
}

function findFolder($path, $fileName)
{
    $filePath = findFolderWithFile($path, $fileName);
    if (!$filePath) {
        echo 'File "' . $fileName . '" not found.';
        die;
    }
    return $filePath;
}
