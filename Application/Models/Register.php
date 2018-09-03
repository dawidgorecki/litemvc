<?php

namespace Models;

use Libraries\Core\Config;
use Libraries\Core\Mail;
use Libraries\Core\Model;
use Libraries\Core\System;
use Libraries\Core\View;
use Libraries\Http\Request;
use Libraries\Http\Session;
use Libraries\Utilities\PasswordUtils;

class Register extends Model
{

    /**
     * @param string $username
     * @return bool
     */
    public function validateUsername(string $username): bool
    {
        if (empty(trim($username))) {
            Session::set('form_username_err', 'This field is required');
            return false;
        }

        if (!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9-_]{3,32}$/', $username)) {
            Session::set('form_username_err', 'Must start with letter and cannot be shorter than 2 characters. 
                Can contain the following characters: a-z A-Z 0-9 - and _');
            return false;
        }

        Session::set('form_username', $username);
        return true;
    }

    /**
     * @param string $email
     * @return boolean
     */
    public function validateEmail(string $email): bool
    {
        if (empty(trim($email))) {
            Session::set('form_email_err', 'This field is required');
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::set('form_email_err', 'Email does not fit into the email naming pattern');
            return false;
        }

        Session::set('form_email', $email);
        return true;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        if (empty($password)) {
            Session::set('form_password_err', 'This field is required');
            return false;
        }

        if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}/', $password)) {
            Session::set('form_password_err', 'Password does not fit into the pattern');
            Session::set('form_password_confirm_err', 'Password does not fit into the pattern');
            return false;
        }

        return true;
    }

    /**
     * @param string $password
     * @param $passwordConfirm
     */
    public function validatePasswordConfirm(string $password, $passwordConfirm)
    {
        if (empty($passwordConfirm)) {
            Session::set('form_password_confirm_err', 'This field is required');
            return false;
        }

        if ($password !== $passwordConfirm) {
            Session::set('form_password_err', 'Passwords are not the same');
            Session::set('form_password_confirm_err', 'Passwords are not the same');
            return false;
        }

        return true;
    }

    /**
     * @param string $termsAgree
     * @return bool
     */
    public function validateTermsAgree(string $termsAgree): bool
    {
        if ($termsAgree !== 'checked') {
            Session::set('form_terms_agree_err', 'You must agree terms and conditions to create an account');
            return false;
        }

        Session::set('form_terms_agree', $termsAgree);
        return true;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $passwordConfirm
     * @param string $termsAgree
     * @return bool
     */
    protected function validateInput(
        string $username,
        string $email,
        string $password,
        string $passwordConfirm,
        string $termsAgree): bool
    {
        $usernameIsValid = $this->validateUsername($username);
        $emailIsValid = $this->validateEmail($email);
        $passwordIsValid = $this->validatePassword($password);
        $passwordConfirmIsValid = $this->validatePasswordConfirm($password, $passwordConfirm);
        $termsAgreeIsValid = $this->validateTermsAgree($termsAgree);

        return ($usernameIsValid && $emailIsValid && $passwordIsValid && $passwordConfirmIsValid && $termsAgreeIsValid);
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $passwordConfirm
     * @return bool
     */
    public function register(
        string $username,
        string $email,
        string $password,
        string $passwordConfirm,
        string $termsAgree): bool
    {
        if (!$this->validateInput($username, $email, $password, $passwordConfirm, $termsAgree)) {
            return false;
        }

        if (!is_null(User::findByUsername($username))) {
            /**
             * Username exists
             */
            Session::add('feedback_negative', 'Username is already taken');
            return false;
        }

        if (!is_null(User::findByEmail($email))) {
            /**
             * Email exists
             */
            Session::add('feedback_negative', 'Email is already in use');
            return false;
        }

        $passwordHash = PasswordUtils::hashPassword($password);
        $activationHash = PasswordUtils::token();

        $user = new User();
        $user->setUsername($username)
            ->setEmail($email)
            ->setPasswordHash($passwordHash)
            ->setRole(User::ROLE_LOGGED_USER)
            ->setIsActive(false)
            ->setActivationHash($activationHash)
            ->setCreatedBy('system');

        $this->getDB()->beginTransaction();

        if (!$user->save()) {
            $this->getDB()->rollback();
            Session::add('feedback_negative', 'Sorry, your registration failed');
            return false;
        }

        /**
         * Send activation link via email
         */
        if ($this->sendActivationLink($user, $email, $activationHash)) {
            $this->getDB()->commit();

            Session::delete([
                'form_username',
                'form_email',
                'form_terms_agree',
            ]);

            Session::add('feedback_positive', 'Your account has been created. Check your email to activate account');
            return true;
        }

        $this->getDB()->rollback();
        return false;
    }

    /**
     * Send email with activation link
     * @param int $id
     * @param string $email
     * @param string $activationHash
     * @return bool
     */
    public function sendActivationLink(User $user, string $email, string $activationHash): bool
    {
        $activationLink = Request::getSiteUrl() . "/activation/" .
            urlencode($user->getUsername()) . '/' . urlencode($activationHash);

        $message = Config::get('EMAIL_VERIFICATION_CONTENT') .
            "<br><a href='{$activationLink}' target='_blank'>{$activationLink}</a>";

        $view = new View();
        $emailBody = $view->render('Templates/email', [
            'title' => Config::get('EMAIL_VERIFICATION_SUBJECT'),
            'message' => $message
        ], false);

        $mail = new Mail();
        $mail->addContent(Config::get('EMAIL_VERIFICATION_SUBJECT'), $emailBody);
        $mail->addRecipient($email);

        if ($mail->sendMessage(
            Config::get('EMAIL_VERIFICATION_FROM_EMAIL'),
            Config::get('EMAIL_VERIFICATION_FROM_NAME'))
        ) {
            return true;
        } else {
            System::log($mail->getError(), __FILE__);
            Session::add('feedback_negative', 'Verification mail could not be sent');

            return false;
        }
    }

    /**
     * @param string $id
     * @param string $activationCode
     * @return bool
     */
    public function activate(string $username, string $hash): bool
    {
        /**
         * @var User $user
         */
        $user = User::findByUsername($username);

        if ($user && $user->getActivationHash() === $hash) {
            $user->setIsActive(true);
            $user->setActivationHash('');
            $user->setModifiedBy('system');

            if ($user->save()) {
                Session::add('feedback_positive', 'Activation was successful! You can now log in');
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

}