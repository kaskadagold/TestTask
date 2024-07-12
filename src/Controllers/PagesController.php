<?php

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Response;

class PagesController extends Controller
{
    const REDIRECT_URL = '/';

    public function home(): Response
    {
        $users = $this->repository()->getUsers();
        return $this->view('home.php', ['users' => $users]);
    }

    public function create(): Response
    {
        $error = null;
        if (isset($_SESSION['passError']) && $_SESSION['passError'] === true) {
            $error = 'Пароли не совпадают.';
            unset($_SESSION['passError']);
        }

        return $this->view('create.php', ['error' => $error]);
    }

    public function store(): Response
    {
        $redirectUrl = static::REDIRECT_URL;

        $name = $this->validateData($_POST['name']);
        $email = $this->validateData($_POST['email']);
        $password = $this->validateData($_POST['password']);
        $passConfirm = $this->validatePassword($_POST['password'], $_POST['passwordConfirmation']);

        if ($passConfirm) {
            $this->repository()->create($name, $email, $password);
        } else {
            $_SESSION['passError'] = true;
            $redirectUrl .= 'create';
        }

        return new Response(header: 'Location: ' . $redirectUrl);
    }

    public function delete(string $id): Response
    {
        $redirectUrl = static::REDIRECT_URL;
        $this->repository()->delete($id);

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

    private function validatePassword(string $password, string $passwordConfirmation): bool
    {
        return $password === $passwordConfirmation;
    }
}
