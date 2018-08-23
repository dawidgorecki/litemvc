<?php

return [
    /**
     * Application settings
     */

    'APP_TITLE' => 'LiteMVC',
    'APP_DESCRIPTION' => 'Simple MVC framework for PHP 7.1.0 and later',
    'APP_LANG' => 'en',
    'LOG_PATH' => realpath(__DIR__ . '/../../Logs'),
    'LOG_FILENAME' => 'error.log',

    /**
     * Smarty configuration
     */

    'PATH_SMARTY_CACHE' => realpath(__DIR__ . '/../../Temp/Smarty/Cache'),
    'PATH_SMARTY_COMPILE' => realpath(__DIR__ . '/../../Temp/Smarty/Compile'),
    'PATH_SMARTY_TEMPLATES' => realpath(__DIR__ . '/../Views'),

    /**
     * Default controller and action
     */

    'DEFAULT_CONTROLLER' => 'page',
    'DEFAULT_ACTION' => 'view',

    /**
     * Database configuration
     */

    'DB_TYPE' => 'pgsql',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'postgres',
    'DB_USER' => 'postgres',
    'DB_PASS' => '',
    'DB_PORT' => '5432',
    'DB_CHARSET' => 'utf8',

    /**
     * SMTP configuration
     */

    'EMAIL_SMTP_HOST' => 'smtp.example.com',
    'EMAIL_SMTP_AUTH' => true,
    'EMAIL_SMTP_USERNAME' => 'user@example.com',
    'EMAIL_SMTP_PASSWORD' => 'secret',
    'EMAIL_SMTP_PORT' => 465,
    'EMAIL_SMTP_ENCRYPTION' => 'ssl',
];