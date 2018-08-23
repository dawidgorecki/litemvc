<?php

$router->add("captcha", "Helpers\Captcha", "getCaptchaImage");
$router->add("", "Page", "view");
$router->add("pages/pricing", "Page", "pricing");
$router->add("pages/checkout", "Page", "checkout");
