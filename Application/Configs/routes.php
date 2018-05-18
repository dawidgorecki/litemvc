<?php

/**
 * URL: '~/captcha'
 * Controller: Helpers\Captcha
 * Action: getCaptchaImage
 */
$router->add("captcha", "Helpers\Captcha", "getCaptchaImage");

/**
 * URL: ~/
 * Controller: Page
 * Action: view
 */
$router->add("", "Page", "view");

/**
 * URL: '~/pages/pricing'
 * Controller: Page
 * Action: pricing
 */
$router->add("pages/pricing", "Page", "pricing");

/**
 * URL: '~/pages/checkout'
 * Controller: Page
 * Action: checkout
 */
$router->add("pages/checkout", "Page", "checkout");


