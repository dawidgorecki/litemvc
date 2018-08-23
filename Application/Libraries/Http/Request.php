<?php

namespace Libraries\Http;

use Libraries\Core\Filter;

class Request
{

    /**
     * Returns the value of a specific key of the GET array
     * @param string $key
     * @param bool $xssFilter
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, bool $xssFilter = false, $default = '')
    {
        if (!isset($_GET[$key])) {
            return $default;
        }

        $value = $_GET[$key];

        if ($xssFilter) {
            return Filter::XSSFilter($value);
        } else {
            return $value;
        }
    }

    /**
     * Returns the value of a specific key of the POST array
     * @param string $key
     * @param bool $xssFilter
     * @param mixed $default
     * @return mixed
     */
    public static function post(string $key, bool $xssFilter = false, $default = '')
    {
        if (!isset($_POST[$key])) {
            return $default;
        }

        $value = $_POST[$key];

        if ($xssFilter) {
            return Filter::XSSFilter($value);
        } else {
            return $value;
        }
    }

    /**
     * Returns the value of a specific key of the COOKIE
     * @param string $key
     * @param bool $xssFilter
     * @param mixed $default
     * @return mixed
     */
    public static function cookie(string $key, bool $xssFilter = false, $default = '')
    {
        if (!isset($_COOKIE[$key])) {
            return $default;
        }

        $value = $_COOKIE[$key];

        if ($xssFilter) {
            return Filter::XSSFilter($value);
        } else {
            return $value;
        }
    }

    /**
     * Returns request method used to access the page, i.e. 'GET', 'POST'
     * @return string
     */
    public static function requestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Returns protocol name
     * @return string
     */
    public static function getProtocol(): string
    {
        return (isset($_SERVER['HTTPS'])) ? "https" : "http";
    }

    /**
     * Checks if connection is secured by SSL certificate
     * @return bool
     */
    public static function isSecured(): bool
    {
        return (self::getProtocol() == 'https') ? true : false;
    }

    /**
     * Returns the Host name
     * @return string
     */
    public static function getHost(): string
    {
        return $_SERVER['HTTP_HOST'];
    }

    /**
     * Returns query string
     * @return string
     */
    public static function getQueryString(): string
    {
        return $_SERVER['QUERY_STRING'];
    }

    /**
     * Returns the Host name with protocol
     * @return string
     */
    public static function getSiteUrl(): string
    {
        return self::getProtocol() . "://" . self::getHost();
    }

    /**
     * Returns requested URL
     * @param bool $withQueryString
     * @return string
     */
    public static function getRequestUrl(bool $withQueryString = true): string
    {
        if ($withQueryString) {
            return $_SERVER['REQUEST_URI'];
        } else {
            return substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'] . '?', '?'));
        }
    }

    /**
     * Returns full URL with protocol, host and query string
     * @return string
     */
    public static function getSiteUrlWithQuery(): string
    {
        return self::getSiteUrl() . self::getRequestUrl();
    }

}
