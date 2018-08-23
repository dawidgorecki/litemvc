<?php

namespace Libraries\Core;

class Filter
{

    /**
     * The XSS filter used to prevent Cross-Site Scripting Attacks
     * @param $value
     * @param bool $stripTags
     * @return string
     */
    public static function XSSFilter(&$value, bool $stripTags = true): string
    {
        if (is_string($value)) {

            if ($stripTags) {
                $value = strip_tags($value);
            }

            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        } else if (is_array($value) || is_object($value)) {
            foreach ($value as &$valueInValue) {
                self::XSSFilter($valueInValue, $stripTags);
            }
        }

        return $value;
    }

}
