<?php

namespace Models;

use Libraries\Core\Config;
use Libraries\Core\Model;
use Libraries\Http\Session;

class Login extends Model
{

    /**
     * @param string $username
     * @return bool
     */
    protected function validateUsername(string $username): bool
    {
        if (empty(trim($username))) {
            Session::set('form_username_err', 'This field is required');
            return false;
        }

        Session::set('form_username', $username);
        return true;
    }

    /**
     * @param string $password
     * @return bool
     */
    protected function validatePassword(string $password): bool
    {
        if (empty($password)) {
            Session::set('form_password_err', 'This field is required');
            return false;
        }

        return true;
    }

    /**
     * Validate user input
     * @param string $username
     * @param string $password
     * @return bool
     */
    protected function validateInput(string $username, string $password): bool
    {
        $usernameIsValid = $this->validateUsername($username);
        $passwordIsValid = $this->validatePassword($password);

        return ($usernameIsValid && $passwordIsValid);
    }

    /**
     * @param User $user
     */
    protected function createUserSession(User $user)
    {
        Session::set('user_logged_in', 1);
        Session::set('user_data', $user);
    }

    /**
     * @param User $user
     */
    protected function resetFailedLoginCount(User $user)
    {
        $query = "UPDATE users SET failed_login_count = 0 WHERE id = " . $user->getId();
        $this->getDB()->query($query);
    }

    /**
     * @param User $user
     */
    protected function updateFailedLoginTimeAndCount(User $user)
    {
        $query = "UPDATE users SET failed_login_count = failed_login_count + 1, last_failed_login = '" .
            date('Y-m-d H:i:s') . "' WHERE id = " . $user->getId();
        $this->getDB()->query($query);
    }

    /**
     * @param User $user
     */
    protected function updateLoginTimestamp(User $user)
    {
        $query = "UPDATE users SET failed_login_count = 0, last_login = '" . date('Y-m-d H:i:s') .
            "' WHERE id = " . $user->getId();
        $this->getDB()->query($query);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login(string $username, string $password): bool
    {
        if (!$this->validateInput($username, $password)) {
            return false;
        }

        $user = User::findByUsernameOrEmail($username);

        if (!$user) {
            Session::set('feedback_negative', 'Wrong username or password');
            return false;
        }

        /**
         * Check if user account was activated
         */
        if (!$user->isActive()) {
            Session::set('feedback_negative', 'Your account is not activated');
            return false;
        }

        /**
         * Check login attempts
         */
        if ($user->getFailedLoginCount() >= Config::get('MAX_LOGIN_ATTEMPTS')) {
            /**
             * Too many login attempts
             */
            if (strtotime($user->getLastFailedLogin()) + Config::get('RESET_ATTEMPTS_AFTER_SEC') > time()) {
                Session::set('feedback_negative', 'Too many login attempts');
                return false;
            } else {
                $this->resetFailedLoginCount($user);
            }
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            /**
             * Wrong password
             */
            $this->updateFailedLoginTimeAndCount($user);
            Session::set('feedback_negative', 'Wrong username or password');
            return false;
        }

        /**
         * Password is correct
         */
        $this->createUserSession($user);
        $this->updateLoginTimestamp($user);

        return true;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        return Session::destroy();
    }

}