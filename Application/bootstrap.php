<?php

use Libraries\Core\System;
use Libraries\Http\Router;

/**
 * Set timezone and locale information
 */
date_default_timezone_set('Europe/Warsaw');
setlocale(LC_COLLATE, 'en_US.UTF-8');

/**
 * Composer autoload
 */
require __DIR__ . '/../Vendor/autoload.php';

/**
 * Set system environment
 */
System::setEnvironment(System::ENV_DEVELOPMENT);

/**
 * Create router object and add routes
 */
$router = new Router;
require __DIR__ . '/../Application/Configs/routes.php';

/**
 * Change default root directory
 * System::setRootDir(realpath(__DIR__ . '/../'));
 */

/**
 * Optional, this can be set in config file also
 * System::setDefaultController('page');
 * System::setDefaultAction('view');
 */

/**
 * Only for tests
 */
session_start();
\Libraries\Http\Session::set('user_logged_in', 1);