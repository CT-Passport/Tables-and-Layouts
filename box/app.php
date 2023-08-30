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
        $this->getFramework();
        $this->pathLogs = JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'logs';
        $this->loadCustomTables();
        $this->loadSpecificCronFile();
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

    public static function print_console(string $string, $logFile = null): void
    {
        $stringLog = str_replace('<br/>', PHP_EOL, $string);
        $stringLog = strip_tags($stringLog);

        if (defined('STDIN'))
            echo $stringLog;
        else
            echo $string;

        if ($logFile !== null) {
            fwrite($logFile, $stringLog);

            @ob_flush();
            @flush();
        }
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
    }

    function loadCustomTables()
    {
        $path = JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_customtables'
            . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'customtables' . DIRECTORY_SEPARATOR;

        require_once($path . 'loader.php');
        CTLoader();
    }

    function doTheJob($dir, $logFilePrefix)
    {
        /**
         * Cron job
         *
         */
        $this->openLogFile($logFilePrefix);
        self::print_console("CRON TASK START<br/>", $this->logFile);

        $path = JPATH_SITE . DIRECTORY_SEPARATOR . $dir;

        $cronFiles = scandir($path);
        foreach ($cronFiles as $cronFile) {
            $fileExtensionPart = explode('.',$cronFile);
            $fileExtension = end($fileExtensionPart);

            if ($cronFile != '.' and $cronFile != '..' and $fileExtension=='php' and $cronFile != 'index.php' and $cronFile != 'app.php') {
                $filename = $path . DIRECTORY_SEPARATOR . $cronFile;
                if (!str_contains($filename, '.htm') and file_exists($filename)) {
                    $fn = str_replace('.php', '', $cronFile);
                    if ($this->functionName == '' or $this->functionName == $fn)//execute all files or one specified
                    {
                        require_once($filename);
                        $functionName = 'cron_' . $fn;
                        self::print_console('<br/>Running task: "' . $functionName . '"<br/>', $this->logFile);
                        $result = call_user_func($functionName, $this->logFile);
                        //TODO: do something with the Result
                    }
                }
            }
        }

        self::print_console("CRON TASK END<br/>", $this->logFile);
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