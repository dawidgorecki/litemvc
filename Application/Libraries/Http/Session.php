<?php

namespace Libraries\Http;

use Libraries\Core\Filter;

class Session
{

    /**
     * Starts the session
     */
    public static function init()
    {
        // If no session exist, start the session
        if (session_id() == '') {
            session_start();
        }
    }

    /**
     * Deletes the session
     */
    public static function destroy()
    {
        session_destroy();
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
     * @param type $value
     */
    public static function add(string $key, $value)
    {
        $_SESSION[$key][] = $value;
    }

    /**
     * Gets the value of a specific key of the session
     * @param string $key
     * @param int $filter
     * @return mixed
     */
    public static function get(string $key, bool $filter = true)
    {
        if (isset($_SESSION[$key])) {

            $value = $_SESSION[$key];
            
            if ($filter) {
                return Filter::XSSFilter($value);
            } else {
                return $value;
            }
        }
        
        return false;
    }

}
