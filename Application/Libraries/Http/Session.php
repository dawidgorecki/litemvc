<?php

namespace Libraries\Http;

use Libraries\Core\Filter;

class Session
{

    /**
     * Starts the session
     * @return bool
     */
    public static function init(): bool
    {
        // If no session exist, start the session
        if (session_id() == '') {
            return session_start();
        }

        return true;
    }

    /**
     * Deletes the session
     * @return bool
     */
    public static function destroy(): bool
    {
        if (session_id() != '') {
            $_SESSION = [];

            if (ini_get("session.use_cookies")) {
                setcookie(session_name(), '', time() - 2592000);
            }

            return session_destroy();
        }

        return true;
    }

    /**
     * Sets a specific value to a specific key of the session
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public static function add(string $key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Delete keys from $_SESSION
     * @param mixed $keys
     */
    public static function delete($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                unset($_SESSION[$key]);
            }
        } else {
            unset($_SESSION[$keys]);
        }
    }

    /**
     * Gets the value of a specific key of the session
     * @param string $key
     * @param bool $xssFilter
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, bool $xssFilter = false, $default = '')
    {
        /**
         * Specified key not exists - return default value
         */
        if (!isset($_SESSION[$key])) {
            return $default;
        }

        $value = $_SESSION[$key];

        if ($xssFilter) {
            return Filter::XSSFilter($value);
        } else {
            return $value;
        }
    }

    /**
     * Checks if user is logged in or not
     * @return bool
     */
    public static function userIsLoggedIn(): bool
    {
        return (self::get('user_logged_in') == 1) ? true : false;
    }

}
