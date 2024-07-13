<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;
use App\Services\AuthorizationService;
use App\Services\UserFormService;
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

        $userName = '';
        if ($isAuthorized = AuthorizationService::isAuthorized()) {
            $userName = $_SESSION['userName'];
        }

        return $this->view('pages/home.php', [
            'users' => $users,
            'success' => $success,
            'error' => $error,
            'isAuthorized' => $isAuthorized,
            'userName' => $userName,
            'isAdmin' => $this->repository()->isAdmin(),
        ]);
    }

    public function create(): Response
    {
        if (! $this->repository()->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . static::REDIRECT_URL);
        }

        $userName = '';
        if ($isAuthorized = AuthorizationService::isAuthorized()) {
            $userName = $_SESSION['userName'];
        }

        $errors = [];
        if (isset($_SESSION['userFormError'])) {
            $errors = $_SESSION['userFormError'];
            unset($_SESSION['userFormError']);
        }

        return $this->view('pages/create.php', [
            'errors' => $errors,
            'isAuthorized' => $isAuthorized,
            'userName' => $userName,
        ]);
    }

    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;

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

        $result = $this->userFormService()->create($fields);

        if (! $result) {
            $redirectUrl .= 'create';
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

        $code = $this->userFormService()->destroy($id);

        return new Response(code: $code, header: 'Location: ' . $redirectUrl);
    }

    public function destroy(): Response
    {
        if (! $this->repository()->isAdmin()) {
            return new Response(code: 403);
        }

        $id = $_POST['id'];
        
        $code = $this->userFormService()->destroy($id);

        return new Response(code: $code);
    }

    private function userFormService(): UserFormService
    {
        return new UserFormService($this->repository());
    }

    private function repository(): UsersRepository
    {
        return new UsersRepository();
    }
}
