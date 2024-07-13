<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;
use App\Services\AuthorizationService;
use App\Services\ValidationService;

class PagesController extends Controller
{
    const REDIRECT_URL = '/';

    public function home(): Response
    {
        $users = $this->repository()->getUsers();

        $success = null;
        if (isset($_SESSION['userFormSuccess'])) {
            $success = $_SESSION['userFormSuccess'];
            unset($_SESSION['userFormSuccess']);
        }

        $error = null;
        if (isset($_SESSION['accessDenied'])) {
            $error = $_SESSION['accessDenied'];
            unset($_SESSION['accessDenied']);
        }

        return $this->view('pages/home.php', [
            'users' => $users,
            'success' => $success,
            'error' => $error,
            'isAuthorized' => AuthorizationService::isAuthorized(),
            'isAdmin' => $this->repository()->isAdmin(),
        ]);
    }

    public function create(): Response
    {
        if (! $this->repository()->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . static::REDIRECT_URL);
        }

        $error = null;
        if (isset($_SESSION['userFormError'])) {
            $error = $_SESSION['userFormError'];
            unset($_SESSION['userFormError']);
        }

        return $this->view('pages/create.php', [
            'error' => $error,
            'isAuthorized' => AuthorizationService::isAuthorized(),
        ]);
    }

    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;
        $success = false;
        $error = false;

        if (! $this->repository()->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . $redirectUrl);
        }

        $fields = [
            'name' => $_POST['name'] ?? null,
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
            'passwordConfirmation' => $_POST['password_confirmation'],
        ];

        $validator = new ValidationService();

        $fields['name'] = $validator->validateData($fields['name']);
        $fields['email'] = $validator->validateData($fields['email']);

        if (!$error = $validator->validateUserForm($fields)) {
            $hashPass = password_hash($fields['password'], PASSWORD_DEFAULT);
            if (! ($this->repository()->create($fields['name'], $fields['email'], $hashPass)) ?: null) {
                $error = 'Ошибка при создании пользователя';
            } else {
                $success = 'Новый пользователь успешно создан';
            }
        }

        if ($error) {
            $_SESSION['userFormError'] = $error;
            $redirectUrl .= 'create';
        }

        if ($success) {
            $_SESSION['userFormSuccess'] = $success;
        }

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    public function delete(string $id): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        if (! $this->repository()->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . $redirectUrl);
        }

        $this->repository()->delete($id);

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    private function repository(): UsersRepository
    {
        return new UsersRepository();
    }
}
