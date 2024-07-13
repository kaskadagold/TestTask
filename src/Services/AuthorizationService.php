<?php

namespace App\Services;

class AuthorizationService
{
    public static function isAuthorized(): bool
    {
        return (bool) ($_SESSION['auth'] ?? false);
    }

    public static function getUserName(): bool
    {
        return (bool) ($_SESSION['user']['name'] ?? '');
    }
}
