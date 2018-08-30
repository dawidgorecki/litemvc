<?php

namespace Controllers;

use Libraries\Core\Controller;
use Libraries\Core\Csrf;
use Libraries\Http\Redirect;
use Libraries\Http\Request;
use Libraries\Http\Session;

class LoginController extends Controller
{

    /**
     * @var \Models\Login
     */
    private $loginModel;

    public function __construct()
    {
        parent::__construct();
        $this->loginModel = $this->getModel();
    }

    /**
     * Override base Controller method
     */
    public function before()
    {
        /**
         * Redirect to the home page if user is logged in
         */
        if (Session::userIsLoggedIn()) {
            Redirect::home();
        }
    }

    public function actionLogin()
    {
        if (Request::requestMethod() == "POST" && Request::post('form_login') == 'form_login') {
            /**
             * Form has been submitted
             */
            $this->login();
        } else {
            $data = [
                'username' => Session::get('form_username', true, ''),
                'username_err' => Session::get('form_username_err', true, ''),
                'password_err' => Session::get('form_password_err', true, '')
            ];

            Session::delete(['form_username', 'form_username_err', 'form_password_err']);
            $this->getView()->render('Login/LoginForm', $data);
        }
    }

    public function actionLogout()
    {
        $this->loginModel->logout();
    }

    public function actionResetPassword()
    {
        // TODO: Implment reset password feature
        die('password_reset');
    }

    protected function login()
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

        if ($this->loginModel->login(
            Request::post('username'),
            Request::post('user_password')
        )) {
            Redirect::home();
        } else {
            Redirect::to('user/login');
        }
    }

}