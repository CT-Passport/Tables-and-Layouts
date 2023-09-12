<?php
/**
 * Passports
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link https://joomlaboat.com
 * @GNU General Public License
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use CustomTables\CT;

function cron_2_update_people($logFile, ?string $file)
{
    if($file!== null) {
        CronAPP::print_console(' - Update people virtual fields.<br/>', $logFile);

        $db = Factory::getDBO();
        $sql = 'SELECT id FROM h82im_customtables_table_people';
        $db->setQuery($sql);
        $rows = $db->loadAssocList();
        CronAPP::print_console(' -- Updating', $logFile);

        $ct = new CT();
        $ct->getTable('people');

        foreach ($rows as $row) {
            CronAPP::print_console('.', $logFile);

            if ($ct->RefreshSingleRecord($row['id'], false) == -1) {
                CronAPP::print_console(' -- ERROR. Record ID: ' . $row['id'] . '<br/>', $logFile);
                return;
            }
        }
    }
}

