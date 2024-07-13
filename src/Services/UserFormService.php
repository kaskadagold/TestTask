<?php

namespace App\Services;
use App\Repositories\UsersRepository;

class UserFormService
{
    public function __construct(private readonly UsersRepository $repository)
    {
    }

    public function create(array $fields): bool
    {
        $errors = [];
        $success = false;
        $fields['name'] = $this->validateData($fields['name']);
        $fields['email'] = $this->validateData($fields['email']);

        if (empty($errors = $this->validateUserForm($fields))) {
            $hashPass = password_hash($fields['password'], PASSWORD_DEFAULT);
            if (! ($this->repository->create($fields['name'], $fields['email'], $hashPass)) ?: null) {
                $errors[] = 'Ошибка при создании пользователя';
            } else {
                $success = 'Новый пользователь успешно создан';
            }
        }

        if (! empty($errors)) {
            $_SESSION['userFormError'] = $errors;
            return false;
        }

        if ($success) {
            $_SESSION['userFormSuccess'] = $success;
        }
        return true;
    }

    public function destroy(string $id): bool | int
    {
        if ((! is_numeric($id)) || gettype($id) === 'double') {
            return 400;
        }

        $id = (int) $id;

        if ($id === $_SESSION['id']) {
            return 406;
        }

        if (! $this->repository->delete($id)) {
            return 500;
        }

        return 200;
    }

    private function validateData(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function validateUserForm(array $fields): bool | array
    {
        $errors = [];
        
        if (empty($fields['name'])) {
            $errors[] = 'Поле "Имя" обязательно для заполнения';
        }

        if (empty($fields['email'])) {
            $errors[] = 'Поле "Email" обязательно для заполнения';
        }

        if (empty($fields['password'])) {
            $errors[] = 'Поле "Пароль" обязательно для заполнения';
        }

        if (mb_strlen($fields['password']) < 6) {
            $errors[] = 'Пароль слишком короткий. Пожалуйста, укажбите пароль, длиной не менее 6 символов';
        }

        if (empty($fields['passwordConfirmation'])) {
            $errors[] = 'Пожалуйста, подствердите пароль';
        }

        if ($fields['password'] !== $fields['passwordConfirmation']) {
            $errors[] = 'Пароли не совпадают';
        }

        if ($this->repository->getUserByName($fields['name'])) {
            $errors[] = 'Пользователь с таким именем уже существует';
        }

        if ($this->repository->getUserByEmail($fields['email'])) {
            $errors[] = 'Пользователь с таким email уже существует';
        }

        return $errors;
    }
}
