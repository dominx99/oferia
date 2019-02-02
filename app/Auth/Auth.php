<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    /**
     * @param integer $userId
     * @return void
     */
    public function authenticate(int $userId): void
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * @return boolean
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * @return false|\App\Models\User
     */
    public function user()
    {
        if (!$this->check()) {
            return false;
        }

        return User::find($_SESSION['user']);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }

    /**
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function attempt(string $email, string $password): bool
    {
        if (!$user = User::whereEmail($email, $password)->first()) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        $this->authenticate($user->id);

        return true;
    }
}
