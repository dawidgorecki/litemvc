<?php

namespace Libraries\Utilities;

use Gregwar\Captcha\CaptchaBuilder;
use Libraries\Http\Session;

class CaptchaUtils
{

    /**
     * Generates the captcha, "returns" a real image
     * @param int $width
     * @param int $height
     * @param int $lines
     * @param array $bgColor
     */
    public static function generateCaptcha(
        int $width,
        int $height,
        int $lines = 3,
        array $bgColor = [255, 255, 255])
    {
        $captcha = new CaptchaBuilder;
        $captcha->setMaxBehindLines($lines);
        $captcha->setMaxFrontLines($lines);
        $captcha->setBackgroundColor($bgColor[0], $bgColor[1], $bgColor[2]);
        $captcha->build($width, $height);

        Session::set('captcha', $captcha->getPhrase());

        header('Content-type: image/jpeg');
        $captcha->output();
    }

    /**
     * Checks if the entered captcha is the same like the one...
     * from the rendered image which has been saved in session
     * @param string $captcha
     * @return bool
     */
    public static function checkCaptcha(string $captcha): bool
    {
        if ($captcha == Session::get('captcha')) {
            return true;
        }

        return false;
    }

}
