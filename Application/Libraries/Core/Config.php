<?php

namespace Libraries\Core;

class Config
{

    private static $config;

    /**
     * Gets config parameter specified by key
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        if (!$key) {
            return null;
        }
        
        if (!self::$config) {
            $configFile = System::getRootDir() . "/Application/Configs/config-" . System::getEnvironment() . ".php";

            if (!file_exists($configFile)) {
                return null;
            }

            self::$config = require $configFile;
        }
        
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }

}
