<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;
use App\Services\AuthorizationService;

class AuthController extends Controller
{
    const REDIRECT_URL = '/';

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

        return $this->view('pages/login.php', [
            'error' => $error,
            'isLoginPage' => true,
        ]);
    }

    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;
        $error = true;

        $name = $_POST['name'];
        $password = $_POST['password'];
        $user = $this->repository()->getUserByName($name);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $user->id;
            $_SESSION['userName'] = $user->name;

            $error = false;
        }

        if ($error) {
            $_SESSION['loginFormError'] = 'Неверный email или пароль';
            $redirectUrl .= 'login';
        }

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    public function destroy(): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        unset($_SESSION['auth']);
        unset($_SESSION['id']);
        unset($_SESSION['userName']);

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    private function repository(): UsersRepository
    {
        return new UsersRepository();
    }
}
