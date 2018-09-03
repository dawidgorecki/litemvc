<?php

namespace Controllers;

use Libraries\Core\Config;
use Libraries\Core\Controller;
use Libraries\Core\Csrf;
use Libraries\Http\Redirect;
use Libraries\Http\Request;
use Libraries\Http\Session;

class RegisterController extends Controller
{

    /**
     * @var \Models\Register
     */
    private $registerModel;

    public function __construct()
    {
        parent::__construct();
        $this->registerModel = $this->getModel();
    }

    /**
     * Override base Controller method
     */
    public function before()
    {
        /**
         * Check if registration is disabled
         */
        if (!Config::get('REGISTRATION')) {
            $error = new ErrorController();
            $error->error404();
            exit();
        }
    }

    protected function register()
    {
        if (!Csrf::isTokenValid()) {
            $error = new ErrorController();
            $error->error(
                'Requested was rejected',
                'Make sure you have access to the thing you tried to change',
                422,
                'Unprocessable Entity'
            );

            exit();
        }

        if ($this->registerModel->register(
            Request::post('username'),
            Request::post('email'),
            Request::post('password'),
            Request::post('password_confirm'),
            Request::post('terms_agree')
        )) {
            Redirect::to('user/login');
        } else {
            Redirect::to('register');
        }
    }

    public function actionRegister()
    {
        if (Request::requestMethod() == "POST" && Request::post('form_register') == 'form_register') {
            /**
             * Form has been submitted
             */
            $this->register();
        } else {
            $data = [
                'username' => Session::get('form_username', true),
                'username_err' => Session::get('form_username_err', true),
                'email' => Session::get('form_email', true),
                'email_err' => Session::get('form_email_err', true),
                'password_err' => Session::get('form_password_err', true),
                'password_confirm_err' => Session::get('form_password_confirm_err', true),
                'terms_agree' => Session::get('form_terms_agree', true),
                'terms_agree_err' => Session::get('form_terms_agree_err', true)
            ];

            Session::delete([
                'form_username',
                'form_username_err',
                'form_email',
                'form_email_err',
                'form_password_err',
                'form_password_confirm_err',
                'form_terms_agree',
                'form_terms_agree_err'
            ]);

            $this->getView()->render('Register/RegisterForm', $data);
        }
    }

    public function actionActivation(string $username, string $hash)
    {
        if ($this->registerModel->activate($username, $hash))
        {
            Redirect::to('user/login');
        }

        $error = new ErrorController();
        $error->error(
            'Requested was rejected',
            'Sorry, no such id/verification code combination here',
            422,
            'Unprocessable Entity'
        );
    }

}