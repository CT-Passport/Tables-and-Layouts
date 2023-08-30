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
$cron->doTheJob('box','box_');