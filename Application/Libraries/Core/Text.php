<?php

namespace Libraries\Core;

class Text
{

    private static $texts;

    /**
     * Gets text connected with the specified key
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        if (!$key) {
            return null;
        }

        if (!self::$texts) {
            $textsFile = System::getRootDir() . "/Application/Configs/texts.php";

            if (!file_exists($textsFile)) {
                return null;
            }

            self::$texts = require $textsFile;
        }

        return isset(self::$texts[$key]) ? self::$texts[$key] : null;
    }

}
