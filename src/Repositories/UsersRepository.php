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

    public function create(string $name, string $email, string $password): void
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

    private function database(): Database
    {
        return new Database();
    }
}
