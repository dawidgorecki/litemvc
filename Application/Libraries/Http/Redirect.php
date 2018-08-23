<?php

namespace Libraries\Http;

class Redirect
{

    /**
     * Redirects to specified path
     * @param string $path
     */
    public static function to(string $path)
    {
        $path = trim($path, "/");
        header("location: " . Request::getSiteUrl() . "/" . $path);
        exit();
    }

    /**
     * Redirects to home page
     */
    public static function home()
    {
        header("location: " . Request::getSiteUrl());
        exit();
    }

}