<?php

namespace App\Auth;

class Auth
{
    /**
     * @param integer $userId
     * @return void
     */
    public function authorize(int $userId): void
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
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}
