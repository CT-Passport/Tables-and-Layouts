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

        if($row_new['es_version'] === null or $row_new['es_version'] === '') {
            $filePath = JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'xls' . DIRECTORY_SEPARATOR . $row_new['es_file'];
            $reader = ReaderEntityFactory::createReaderFromFile($filePath);
            $reader->open($filePath);
            $version = CronAPP::findVersion($reader); //column "PL OF STAY DETAILS" name
            $db = JFactory::getDBO();
            $query = 'UPDATE #__customtables_table_excelfiles SET es_version=' . $db->quote($version) . ' WHERE id = ' . $row_new['id'];
            $db->setQuery($query);
            $db->execute();
        }
    }
}
