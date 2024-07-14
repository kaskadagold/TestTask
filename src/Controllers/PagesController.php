<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;
use App\Services\AuthorizationService;
use App\Services\UserFormService;

class PagesController extends Controller
{
    public const REDIRECT_URL = '/';
    private readonly UsersRepository $repository;
    private readonly UserFormService $userFormService;

    public function __construct()
    {
        $this->repository = new UsersRepository();
        $this->userFormService = new UserFormService($this->repository);
    }

    // Получение и отображение полного списка пользователей
    public function home(): Response
    {
        $users = $this->repository->getUsers();

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
            $userName = AuthorizationService::getUserName();
        }

        return $this->view('pages/home.php', [
            'users' => $users,
            'success' => $success,
            'error' => $error,
            'isAuthorized' => $isAuthorized,
            'userName' => $userName,
            'isAdmin' => $this->repository->isAdmin(),
        ]);
    }

    // Отображение страницы с формой создания пользователя
    public function create(): Response
    {
        if (! $this->repository->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . static::REDIRECT_URL);
        }

        $userName = '';
        if ($isAuthorized = AuthorizationService::isAuthorized()) {
            $userName = AuthorizationService::getUserName();
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

    // Сохранение созданного пользователя в БД
    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        if (! $this->repository->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . $redirectUrl);
        }

        $fields = [
            'name' => $_POST['name'] ?? null,
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
            'passwordConfirmation' => $_POST['password_confirmation'] ?? null,
        ];

        $result = $this->userFormService->create($fields);

        if (! $result) {
            $redirectUrl .= 'create';
        }

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    // Удаление пользователя из БД без AJAX-запроса
    public function delete(string $id): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        if (! $this->repository->isAdmin()) {
            $_SESSION['accessDenied'] = 'Доступ запрещен. Вы не администратор';
            return new Response(header: 'Location: ' . $redirectUrl);
        }

        $code = $this->userFormService->destroy($id);

        return new Response(code: $code, header: 'Location: ' . $redirectUrl);
    }

    // Удаление пользователя из БД с исользованием AJAX-запроса
    public function destroy(): Response
    {
        if (! $this->repository->isAdmin()) {
            return new Response(code: 403);
        }

        $id = $_POST['id'];
        
        $code = $this->userFormService->destroy($id);

        return new Response(code: $code);
    }
}
