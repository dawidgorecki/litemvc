<?php

namespace Libraries\Core;

use Libraries\Http\Request;
use Libraries\Http\Session;
use Libraries\Utilities\PasswordUtils;

class Csrf
{

    /**
     * Get CSRF token and generate a new one if expired
     * @return string
     */
    public static function generateToken(): string
    {
        $maxTime = 60 * 60 * 24;
        $storedTime = Session::get('csrf_token_time');
        $csrfToken = Session::get('csrf_token');

        if (empty($csrfToken) || $storedTime + $maxTime <= time()) {
            Session::set('csrf_token', PasswordUtils::token());
            Session::set('csrf_token_time', time());
        }

        return Session::get('csrf_token');
    }

    /**
     * Checks if CSRF token in session is same as in the form submitted
     * @return bool
     */
    public static function isTokenValid(): bool
    {
        $token = Request::post('csrf_token');
        return $token === Session::get('csrf_token') && !empty($token);
    }

}