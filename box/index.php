<?php
/**
 * Passports
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link https://joomlaboat.com
 * @GNU General Public License
 **/

$path = '';//'../includes' . DIRECTORY_SEPARATOR;
require_once($path . 'app.php');
$cron = new CronAPP();
$jinput = JFactory::getApplication()->input;

$file = $jinput->getString("file");
$cron->doTheJob('box', 'box_', $file);

$returnto = $jinput->get("returnto", null, 'BASE64');
if ($returnto !== null) {
    header("Location: ".base64_decode($returnto));
}