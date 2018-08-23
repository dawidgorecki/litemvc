<?php

namespace Libraries\Core;

class Text
{

    /**
     * @var array
     */
    private static $texts;

    /**
     * Gets text connected with the specified key
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function get(string $key, string $default = ''): string
    {
        if (!$key) {
            return $default;
        }

        if (!self::$texts) {
            $textsFile = System::getRootDir() . "/Application/Configs/texts.php";

            if (!file_exists($textsFile)) {
                return $default;
            }

            self::$texts = require $textsFile;
        }

        return isset(self::$texts[$key]) ? self::$texts[$key] : $default;
    }

}
