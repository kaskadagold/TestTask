<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;
use App\Services\AuthorizationService;

class AuthController extends Controller
{
    const REDIRECT_URL = '/';

    // Отображение страницы с формой авторизации
    public function login(): Response
    {
        if (AuthorizationService::isAuthorized()) {
            return new Response(header: 'Location: ' . static::REDIRECT_URL);
        }

        $error = null;
        if (isset($_SESSION['loginFormError'])) {
            $error = $_SESSION['loginFormError'];
            unset($_SESSION['loginFormError']);
        }

        return $this->view('pages/login.php', ['error' => $error]);
    }

    // Процесс авторизации
    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;
        $error = true;

        $name = $this->validateData($_POST['name']);
        $password = $_POST['password'];
        $user = $this->repository()->getUserByName($name);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['auth'] = true;
            $_SESSION['user']['id'] = $user->id;
            $_SESSION['user']['name'] = $user->name;

            $error = false;
        }

        if ($error) {
            $_SESSION['loginFormError'] = 'Неверный email или пароль';
            $redirectUrl .= 'login';
        }

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    // Процесс разавторизации
    public function destroy(): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        unset($_SESSION['auth']);
        unset($_SESSION['user']);

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    private function repository(): UsersRepository
    {
        return new UsersRepository();
    }

    private function validateData(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
