<?php

namespace Libraries\Core;

class Filter
{

    /**
     * The XSS filter used to prevent Cross-Site Scripting Attacks
     * @param type $value
     * @return mixed
     */
    public static function XSSFilter(&$value)
    {
        if (is_string($value)) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        } else if (is_array($value) || is_object($value)) {
            foreach ($value as &$valueInValue) {
                self::XSSFilter($valueInValue);
            }
        }

        return $value;
    }

}
