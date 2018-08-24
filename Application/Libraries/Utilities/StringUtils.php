<?php

namespace Libraries\Utilities;

class StringUtils
{

    /**
     * Convert the string to StudlyCaps
     * @param string $string
     * @return string
     */
    public static function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase
     * @param string $string
     * @return string
     */
    public static function convertToCamelCase(string $string): string
    {
        return lcfirst(self::convertToStudlyCaps($string));
    }

    /**
     * Convert CamelCase string to array
     * @param string $string
     * @return array
     */
    public static function splitByCapitalLetter(string $string): array
    {
        return preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Replace all local characters to corresponding latin character
     * @param string $string
     * @return string
     */
    public static function normalize(string $string): string
    {
        $polishChars = [' ', 'ą', 'ć', 'ę', 'ł', 'ń', 'ó', 'ś', 'ź', 'ż', 'Ą', 'Ć', 'Ę', 'Ł', 'Ń', 'Ó', 'Ś', 'Ź', 'Ż'];
        $latinChars = ['_', 'a', 'c', 'e', 'l', 'n', 'o', 's', 'z', 'z', 'A', 'C', 'E', 'L', 'N', 'O', 'S', 'Z', 'Z'];

        return str_replace($polishChars, $latinChars, $string);
    }

    /**
     * Replace any special character by hyphens
     * @param string $string
     * @return string
     */
    public static function slugify(string $string): string
    {
        $string = self::normalize(trim($string));
        $string = preg_replace('/[^a-z0-9]/', '-', strtolower(strip_tags($string)));
        $string = trim($string, "-");

        while (strpos($string, "--") !== false) {
            $string = str_replace("--", "-", $string);
        }

        return $string;
    }

}
