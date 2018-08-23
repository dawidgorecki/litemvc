<?php

namespace Libraries\Core;

class System
{

    const ENV_DEVELOPMENT = 'devel';
    const ENV_PRODUCTION = 'production';

    const E_GENERAL = "Error";
    const E_WARNING = "Warning";
    const E_NOTICE = "Notice";

    /**
     * @var string
     */
    private static $rootDir;

    /**
     * @var \Libraries\Core\Application
     */
    private static $application;

    /**
     * @var string
     */
    private static $defaultController;

    /**
     * @var string
     */
    private static $defaultAction;

    /**
     * Sets application ROOT directory
     * @param string $path
     */
    public static function setRootDir(string $path)
    {
        self::$rootDir = rtrim(str_replace("\\", "/", $path), "/");
    }

    /**
     * Gets application ROOT directory
     * @return string
     */
    public static function getRootDir(): string
    {
        return self::$rootDir ?? realpath(__DIR__ . '/../../../');
    }

    /**
     * Sets application environment
     * @param string $env
     * @return bool
     */
    public static function setEnvironment(string $env): bool
    {
        $logFile = Config::get('LOG_PATH') . '/' . Config::get('LOG_FILENAME');

        error_reporting(E_ALL);
        ini_set('log_errors', 1);
        ini_set('error_log', $logFile);

        if ($env == self::ENV_DEVELOPMENT) {
            ini_set('display_errors', 1);
        } else {
            ini_set('display_errors', 0);
        }

        return putenv("APPLICATION_ENV=" . $env);
    }

    /**
     * Gets application environment - default is production
     * @return string
     */
    public static function getEnvironment(): string
    {
        return getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : self::ENV_PRODUCTION;
    }

    /**
     * Register a new application
     * @param Application $app
     */
    public static function registerApplication(Application $app)
    {
        self::$application = $app;
    }

    /**
     * Gets application instance
     * @return Application|null
     */
    public static function getApplication(): ?Application
    {
        return self::$application;
    }

    /**
     * Gets default Controller
     * @return string
     */
    public static function getDefaultController(): string
    {
        return self::$defaultController ?? Config::get('DEFAULT_CONTROLLER', 'Page');
    }

    /**
     * Sets default Controller
     * @param string $controllerName
     */
    public static function setDefaultController(string $controllerName)
    {
        self::$defaultController = $controllerName;
    }

    /**
     * Gets default Controller action
     * @return string
     */
    public static function getDefaultAction(): string
    {
        return self::$defaultAction ?? Config::get('DEFAULT_ACTION', 'view');
    }

    /**
     * Sets default action for Controller
     * @param string $actionName
     */
    public static function setDefaultAction(string $actionName)
    {
        self::$defaultAction = $actionName;
    }

    /**
     * Add log
     * @param string $msg
     * @param string $file
     * @param string $level
     * @return bool
     */
    public static function log(string $msg, string $file, string $level = self::E_GENERAL): bool
    {
        $log = "[{$file}] {$level}: $msg" . PHP_EOL;
        return error_log($log, 0);
    }

}
