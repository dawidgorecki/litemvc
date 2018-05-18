<?php

use Libraries\Core\Application;
use Libraries\Core\System;

require '../Application/bootstrap.php';

$application = new Application($router);
System::registerApplication($application);

$application->init();