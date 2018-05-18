<?php

namespace Libraries\Core;

class System
{

    const ENV_DEVELOPMENT = 'devel';
    const ENV_PRODUCTION = 'production';

    private static $rootDir;
    private static $debugMode;
    private static $application;
    private static $defaultController;
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
     * Turn on error reporting
     * @param bool $debugMode
     */
    public static function setDebugMode(bool $debugMode)
    {
        ini_set('display_errors', $debugMode);

        if ($debugMode) {
            // Report all PHP errors
            error_reporting(E_ALL);
        } else {
            // Turn off all error reporting
            error_reporting(0);
        }

        self::$debugMode = $debugMode;
    }

    /**
     * Check if debug mode is on
     * @return bool
     */
    public static function isDebugMode(): bool
    {
        return self::$debugMode ?? false;
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
     * @return mixed
     */
    public static function getApplication()
    {
        return isset(self::$application) ? self::$application : null;
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
     * Gets default Controller
     * @return string
     */
    public static function getDefaultController(): string
    {
        return self::$defaultController ?? Config::get('DEFAULT_CONTROLLER');
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
     * Gets default Controller action
     * @return string
     */
    public static function getDefaultAction(): string
    {
        return self::$defaultAction ?? Config::get('DEFAULT_ACTION');
    }

}
