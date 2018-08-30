<?php

$router->add("captcha", "Helpers\Captcha", "getCaptchaImage");
$router->add("", "Page", "view");
$router->add("pages/pricing", "Page", "pricing");
$router->add("pages/checkout", "Page", "checkout");
$router->add("user/login", "Login", "actionLogin");
$router->add("user/logout", "Login", "actionLogout");
$router->add("user/reset-password", "Login", "actionResetPassword");