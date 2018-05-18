<?php

namespace Libraries\Http;

use Libraries\Core\Filter;

class Request
{

    /**
     * Returns the value of a specific key of the GET superglobal
     * @param string $key
     * @param bool $filter
     * @return mixed
     */
    public static function get(string $key, bool $filter = true)
    {
        if (isset($_GET[$key])) {
            
            $value = $_GET[$key];
            
            if ($filter) {
                return Filter::XSSFilter($value);
            } else {
                return $value;
            }
        }
        
        return false;
    }

    /**
     * Returns the value of a specific key of the POST superglobal
     * @param string $key
     * @param bool $filter
     * @return mixed
     */
    public static function post(string $key, bool $filter = true)
    {
        if (isset($_POST[$key])) {
            
            $value = $_POST[$key];
            
            if ($filter) {
                return Filter::XSSFilter($value);
            } else {
                return $value;
            }
        }
        
        return false;
    }

    /**
     * Returns the value of a specific key of the COOKIE superglobal
     * @param string $key
     * @param bool $filter
     * @return mixed
     */
    public static function cookie(string $key, bool $filter = true)
    {
        if (isset($_COOKIE[$key])) {
           
            $value = $_COOKIE[$key];
            
            if ($filter) {
                return Filter::XSSFilter($value);
            } else {
                return $value;
            }
        }
        
        return false;
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
