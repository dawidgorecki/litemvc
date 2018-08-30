<?php

namespace Models;

use Libraries\Core\Model;

class User extends Model
{

    const ROLE_ADMIN = 1;
    const ROLE_LOGGED_USER = 2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password_hash;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var integer
     */
    private $role;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var string
     */
    private $last_login;

    /**
     * @var string
     */
    private $last_failed_login;

    /**
     * @var integer
     */
    private $failed_login_count;

    /**
     * @var string
     */
    private $activation_hash;

    /**
     * @var string
     */
    private $password_reset_hash;

    /**
     * @var string
     */
    private $password_reset_timestamp;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $created_by;

    /**
     * @var string
     */
    private $modified_at;

    /**
     * @var string
     */
    private $modified_by;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): ?string
    {
        return $this->password_hash;
    }

    /**
     * @param string $password_hash
     * @return User
     */
    public function setPasswordHash(?string $password_hash): User
    {
        $this->password_hash = $password_hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName(?string $first_name): User
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName(?string $last_name): User
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): ?int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return User
     */
    public function setRole(?int $role): User
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     * @return User
     */
    public function setIsActive(?bool $is_active): User
    {
        $this->is_active = $is_active;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastLogin(): ?string
    {
        return $this->last_login;
    }

    /**
     * @param string $last_login
     * @return User
     */
    public function setLastLogin(?string $last_login): User
    {
        $this->last_login = $last_login;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastFailedLogin(): ?string
    {
        return $this->last_failed_login;
    }

    /**
     * @param string $last_failed_login
     * @return User
     */
    public function setLastFailedLogin(?string $last_failed_login): User
    {
        $this->last_failed_login = $last_failed_login;
        return $this;
    }

    /**
     * @return int
     */
    public function getFailedLoginCount(): ?int
    {
        return $this->failed_login_count;
    }

    /**
     * @param int $failed_login_count
     * @return User
     */
    public function setFailedLoginCount(?int $failed_login_count): User
    {
        $this->failed_login_count = $failed_login_count;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivationHash(): ?string
    {
        return $this->activation_hash;
    }

    /**
     * @param string $activation_hash
     * @return User
     */
    public function setActivationHash(?string $activation_hash): User
    {
        $this->activation_hash = $activation_hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordResetHash(): ?string
    {
        return $this->password_reset_hash;
    }

    /**
     * @param string $password_reset_hash
     * @return User
     */
    public function setPasswordResetHash(?string $password_reset_hash): User
    {
        $this->password_reset_hash = $password_reset_hash;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordResetTimestamp(): ?string
    {
        return $this->password_reset_timestamp;
    }

    /**
     * @param string $password_reset_timestamp
     * @return User
     */
    public function setPasswordResetTimestamp(?string $password_reset_timestamp): User
    {
        $this->password_reset_timestamp = $password_reset_timestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     * @return User
     */
    public function setCreatedAt(?string $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): ?string
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     * @return User
     */
    public function setCreatedBy(?string $created_by): User
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return string
     */
    public function getModifiedAt(): ?string
    {
        return $this->modified_at;
    }

    /**
     * @param string $modified_at
     * @return User
     */
    public function setModifiedAt(?string $modified_at): User
    {
        $this->modified_at = $modified_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getModifiedBy(): ?string
    {
        return $this->modified_by;
    }

    /**
     * @param string $modified_by
     * @return User
     */
    public function setModifiedBy(?string $modified_by): User
    {
        $this->modified_by = $modified_by;
        return $this;
    }

    /**
     * Get user by username or email address
     * @param string $username
     * @return User|null
     */
    public static function findByUsernameOrEmail(string $username): ?User
    {
        $query = "SELECT * FROM users WHERE username = :username OR email = :username LIMIT 1";
        $objects = self::findByQuery($query, [':username' => $username]);

        return !empty($objects) ? $objects[0] : null;
    }

    /**
     * Check if user has specific role
     * @param int $role
     * @return bool
     */
    public function hasRole(int $role): bool
    {
        return ($this->getRole() == $role) ? true : false;
    }

}