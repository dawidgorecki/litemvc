<?php

namespace Libraries\Core;

class Config
{

    /**
     * @var array
     */
    private static $config;

    /**
     * Gets config parameter specified by key
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = '')
    {
        if (!$key) {
            return $default;
        }

        if (!self::$config) {
            $configFile = System::getRootDir() . "/Application/Configs/config-" . System::getEnvironment() . ".php";

            if (!file_exists($configFile)) {
                return $default;
            }

            self::$config = require $configFile;
        }

        return isset(self::$config[$key]) ? self::$config[$key] : $default;
    }

}
