<?php

namespace Controllers\Helpers;

use Libraries\Core\Controller;
use Libraries\Utilities\CaptchaUtils;

class CaptchaController extends Controller
{

    /**
     * Returns captcha image
     */
    public function getCaptchaImage()
    {
        /**
         * [$red, $green, $blue]
         */
        $backgroundColor = [255, 255, 255];
        CaptchaUtils::generateCaptcha(200, 80, 2, $backgroundColor);
    }

}
