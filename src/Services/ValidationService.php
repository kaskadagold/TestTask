<?php

namespace App\Services;

class ValidationService
{
    public function validateData(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function validateUserForm(array $fields): bool | string
    {
        if (empty($fields['name'])) {
            return 'Поле "Имя" обязательно для заполнения';
        }

        if (empty($fields['email'])) {
            return 'Поле "Email" обязательно для заполнения';
        }

        if (empty($fields['password'])) {
            return 'Поле "Пароль" обязательно для заполнения';
        }

        if (mb_strlen($fields['password']) < 6) {
            return 'Пароль слишком короткий. Пожалуйста, укажбите пароль, длиной не менее 6 символов';
        }

        if (empty($fields['passwordConfirmation'])) {
            return 'Пожалуйста, подствердите пароль';
        }

        if ($fields['password'] !== $fields['passwordConfirmation']) {
            return 'Пароли не совпадают';
        }

        return false;
    }
}
