<?php

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Factory;

/**
 * Passports
 * @author Ivan Komlev <ivankomlev@gmail.com>
 * @link https://joomlaboat.com
 * @GNU General Public License
 **/
class CronAPP
{
    var string $functionName;
    var string $pathLogs;
    var $logFile;

    function __construct()
    {
        $this->logFile = null;
        $this->getFramework();
        $this->pathLogs = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'logs';
        $this->loadCustomTables();
        $this->loadSpecificCronFile();
    }

    public static function print_console(string $string, $logFile = null): void
    {
        $stringLog = str_replace('<br/>', PHP_EOL, $string);
        $stringLog = strip_tags($stringLog);

        if ($logFile === null) {
            if (defined('STDIN'))
                echo $stringLog;
            else
                echo $string;
        }

        if ($logFile !== null) {
            fwrite($logFile, $stringLog);

            //@ob_flush();
            //@flush();
        }
    }

    static public function findSheet($reader, $sheetName)
    {
        foreach ($reader->getSheetIterator() as $sheet) {

            if ($sheet->getName() == $sheetName) {
                return $sheet;
            }
        }
        return null;
    }

    static public function firstSheet($reader)
    {
        foreach ($reader->getSheetIterator() as $sheet)
            return $sheet;

        return null;
    }

    static public function getColumnIndex(string $columnName): int
    {
        $index = 0;
        $length = strlen($columnName);

        for ($i = 0; $i < $length; $i++) {
            $char = strtoupper($columnName[$i]);
            $index = $index * 26 + (ord($char) - 64);
        }
        return $index - 1;
    }

    static public function columnIndexToName(int $index): string
    {
        $columnName = '';

        while ($index > 0) {
            $modulo = ($index - 1) % 26;
            $columnName = chr(65 + $modulo) . $columnName;
            $index = intdiv($index - $modulo - 1, 26);
        }

        return $columnName;
    }

    static public function findColumnLabelIndexes($reader): array
    {
        $indexes = [];
        $sheet = CronAPP::firstSheet($reader);
        foreach ($sheet->getRowIterator() as $row) {
            $cells = $row->getCells();
            $statusColFound = false;
            $index = 0;
            foreach ($cells as $cell) {
                $value = $cell->getValue();
                if (!$statusColFound) {
                    if ($value == "STATUS") {
                        $statusColFound = true;
                        $indexes[$value] = $index;
                    }
                } else {
                    if ($value !== '') {
                        if (isset($indexes[$value])) {
                            //echo 'Column "' . $value . '" already exists.';
                        } else {
                            $indexes[$value] = $index;
                        }
                    }
                }
                $index += 1;
            }

            if ($statusColFound)
                break;
        }
        return $indexes;
    }

    static public function findVersion($reader)
    {
        $sheet = CronAPP::firstSheet($reader);
        foreach ($sheet->getRowIterator() as $row) {
            $cells = $row->getCells();
            $statusColFound = false;
            $index = 0;
            foreach ($cells as $cell) {
                $value = $cell->getValue();
                if (!$statusColFound) {
                    if ($value == "STATUS")
                        $statusColFound = true;
                } else {
                    if ($value == "PL OF STAY DETAILS")
                        return CronAPP::columnIndexToName($index + 1);
                }
                $index += 1;
            }

            if ($statusColFound) {
                return CronAPP::columnIndexToName($index);
            }
        }
        return null;
    }

    function loadSpecificCronFile()
    {
        if (isset($_GET['function']))
            $this->functionName = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['function']);//JFactory Application not defined yet
        elseif (isset($_POST['function']))
            $this->functionName = preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['function']);//JFactory Application not defined yet
        else
            $this->functionName = '';
    }

    public static function convertDate(?string $originalDate)
    {
        if($originalDate === null)
            return null;

        if (strlen($originalDate) == 10) {
            $parts = explode('.', $originalDate);

            if (count($parts) == 3) {
                //Russian format
                $year = (int)$parts[2];
                $month = (int)$parts[1];
                $day = (int)$parts[0];
                return sprintf("%04d-%02d-%02d", $year, $month, $day);
            }
        }

        // Define month abbreviations mapping from Polish to English
        $monthAbbreviations = array(
            'JAN' => '01', 'FEB' => '02', 'MAR' => '03', 'APR' => '04',
            'MAY' => '05', 'JUN' => '06', 'JUL' => '07', 'AUG' => '08',
            'SEP' => '09', 'OCT' => '10', 'NOV' => '11', 'DEC' => '12'
        );

        // Split by '/' to get the abbreviation part and year
        $parts = explode('/', $originalDate);
        if (count($parts) !== 2) {
            $parts = explode(' ', $originalDate);
            $dayYearPart = trim($parts[0]);

            if (!isset($parts[1]))
                return false;

            $abbreviationPart = trim($parts[1]);
            $numericMonth = $monthAbbreviations[$abbreviationPart] ?? '';

            if (!isset($parts[2]))
                return false;

            $year = trim($parts[2]);
        } else {
            // Extract day and year
            $dayYearPart = explode(' ', $parts[0])[0];

            $abbreviationPart = trim($parts[1]);
            // Convert month abbreviation to English
            $monthPart = explode(' ', $abbreviationPart);
            $numericMonth = $monthAbbreviations[$monthPart[0]] ?? '';

            $yearPart = trim($parts[1]);
            $year = explode(' ', $yearPart)[1];
        }

        if (!$numericMonth) {
            return false; // Invalid month abbreviation
        }

        // Convert to yyyy-mm-dd format
        return sprintf("%04d-%02d-%02d", $year, $numericMonth, $dayYearPart);
    }

    function getFramework()
    {
        // Initialize Joomla framework
        define("_JEXEC", 1);

        /**
         * Constant that is checked in included files to prevent direct access.
         * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
         */

        // Saves the start time and memory usage.
        $startTime = microtime(1);
        $startMem = memory_get_usage();

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $dir = str_replace('\box', '', __DIR__);
        $dir = str_replace('/box', '', $dir);

        define('JPATH_BASE', $dir);

        if (file_exists(JPATH_BASE . '/defines.php')) {
            include_once JPATH_BASE . '/defines.php';
        }

        if (!defined('_JDEFINES')) {
            require_once '../includes/defines.php';
        }

        // Get the framework.
        // Check for presence of vendor dependencies not included in the git repository
        if (!file_exists(JPATH_LIBRARIES . '/vendor/autoload.php') || !is_dir(JPATH_ROOT . '/media/vendor')) {
            echo file_get_contents(JPATH_ROOT . '/templates/system/build_incomplete.html');
            exit;
            die;
        }

        require_once JPATH_BASE . '/includes/framework.php';

        // Set profiler start time and memory usage and mark afterLoad in the profiler.
        JDEBUG ? JProfiler::getInstance('Application')->setStart($startTime, $startMem)->mark('afterLoad') : null;

        // Boot the DI container
        $container = Factory::getContainer();

        /*
         * Alias the session service keys to the web session service as that is the primary session backend for this application
         *
         * In addition to aliasing "common" service keys, we also create aliases for the PHP classes to ensure autowiring objects
         * is supported.  This includes aliases for aliased class names, and the keys for aliased class names should be considered
         * deprecated to be removed when the class name alias is removed as well.
         */
        $container->alias('session.web', 'session.web.site')
            ->alias('session', 'session.web.site')
            ->alias('JSession', 'session.web.site')
            ->alias(\Joomla\CMS\Session\Session::class, 'session.web.site')
            ->alias(\Joomla\Session\Session::class, 'session.web.site')
            ->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

        // Instantiate the application.
        $app = $container->get(SiteApplication::class);

        // Set the application as global app
        \Joomla\CMS\Factory::$application = $app;
    }

    function loadCustomTables()
    {
        $path = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_customtables'
            . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'customtables' . DIRECTORY_SEPARATOR;

        require_once($path . 'loader.php');
        CTLoader(false, false, null, 'com_customtables', true);
    }

    function doTheJob($dir, $logFilePrefix, $file = null)
    {
        /**
         * Cron job
         *
         */

        if ($file !== null)
            $this->openLogFile($logFilePrefix);

        self::print_console("CRON TASK START<br/>", $this->logFile);

        $path = JPATH_SITE . DIRECTORY_SEPARATOR . $dir;

        $cronFiles = scandir($path);
        foreach ($cronFiles as $cronFile) {
            $fileExtensionPart = explode('.', $cronFile);
            $fileExtension = end($fileExtensionPart);

            if ($cronFile != '.' and $cronFile != '..' and $fileExtension == 'php' and $cronFile != 'index.php' and $cronFile != 'app.php') {
                $filename = $path . DIRECTORY_SEPARATOR . $cronFile;
                if (!str_contains($filename, '.htm') and file_exists($filename)) {
                    $fn = str_replace('.php', '', $cronFile);
                    if ($this->functionName == '' or $this->functionName == $fn)//execute all files or one specified
                    {
                        require_once($filename);
                        $functionName = 'cron_' . $fn;
                        self::print_console('<br/>Running task: "' . $functionName . '"<br/>', $this->logFile);
                        $result = call_user_func($functionName, $this->logFile, $file);
                        //TODO: do something with the Result
                    }
                }
            }
        }

        self::print_console("CRON TASK END<br/>", $this->logFile);
        if ($file !== null)
            $this->closeLogFile();
    }

    function openLogFile($logFilePrefix)
    {
        $fileName = $logFilePrefix . date('Y-m-d_his') . '.txt';
        $fileNamePath = $this->pathLogs . DIRECTORY_SEPARATOR . $fileName;
        self::print_console('CronAPP Log file: ' . $fileNamePath . '<br/>');

        $this->logFile = fopen($fileNamePath, "a", 1);
    }

    function closeLogFile(): void
    {
        fclose($this->logFile);
    }
}