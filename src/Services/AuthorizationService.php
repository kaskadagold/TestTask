<?php

namespace App\Services;

class AuthorizationService
{
    public static function isAuthorized(): bool
    {
        return (bool) ($_SESSION['auth'] ?? false);
    }

    public static function userName(): bool
    {
        return (bool) ($_SESSION['userName'] ?? '');
    }
}
