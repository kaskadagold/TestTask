<?php

namespace App\Services;

class AuthorizationService
{
    public static function isAuthorized(): bool
    {
        return (bool) ($_SESSION['auth'] ?? false);
    }
}
