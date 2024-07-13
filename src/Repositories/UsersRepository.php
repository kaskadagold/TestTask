<?php

namespace App\Repositories;
use App\Database;
use PDO;
use App\Models\User;

class UsersRepository
{
    public function getUsers(): array
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'SELECT *
            FROM `users`'
        );
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [-1, '', '', '', '']);
        $result = [];

        while ($temp = $query->fetch()) {
            $result[] = $temp;
        }

        return $result;
    }

    public function create(string $name, string $email, string $password): int
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'INSERT INTO `users` (`name`, `email`, `password`)
            VALUES (:name, :email, :password)'
        );
        $query->bindParam(':name', $name);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password);
        $query->execute();

        return (int) $connection->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'DELETE FROM `users`
            WHERE `id` = :id'
        );
        $query->bindParam(':id', $id);
        $query->execute();

        return $query->rowCount() ? true : false;
    }

    public function getUserByName(string $name): User | bool
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'SELECT *
            FROM `users`
            WHERE `name` = :name
            LIMIT 1'
        );
        $query->bindParam(':name', $name);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [-1, '', '', '', '']);

        if ($temp = $query->fetch()) {
            return $temp;
        }

        return false;
    }

    public function getUserByEmail(string $email): User | bool
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'SELECT *
            FROM `users`
            WHERE `email` = :email
            LIMIT 1'
        );
        $query->bindParam(':email', $email);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [-1, '', '', '', '']);

        if ($temp = $query->fetch()) {
            return $temp;
        }

        return false;
    }

    public function isAdmin(): bool
    {
        if (isset($_SESSION['user']['id'])) {
            $user = $this->getUserById($_SESSION['user']['id']);
            if ($user && $user->name === 'admin' && password_verify('admin', $user->password)) {
                return true;
            }
        }

        return false;
    }

    private function getUserById(int $id): User | bool
    {
        $connection = $this->database()->connect();

        $query = $connection->prepare(
            'SELECT *
            FROM `users`
            WHERE `id` = :id
            LIMIT 1'
        );
        $query->bindParam(':id', $id);
        $query->execute();

        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, User::class, [-1, '', '', '', '']);

        if ($temp = $query->fetch()) {
            return $temp;
        }

        return false;
    }

    private function database(): Database
    {
        return new Database();
    }
}
