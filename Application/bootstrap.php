<?php

use Libraries\Core\System;
use Libraries\Http\Router;

// Set timezone and locale information
date_default_timezone_set('Europe/Warsaw');
setlocale(LC_COLLATE, 'en_US.UTF-8');

// Composer autoload
require __DIR__ . '/../Vendor/autoload.php';

// Set system environment
System::setEnvironment(System::ENV_DEVELOPMENT);

// Turn on all error reporting, and report all PHP errors
System::setDebugMode(true);

// Change default root directory
// System::setRootDir(realpath(__DIR__ . '/../'));

// Optional, this can be set in config file also
// System::setDefaultController('page');
// System::setDefaultAction('view');

// Create router object 
$router = new Router;

// ...and add routes
require '../Application/Configs/routes.php';