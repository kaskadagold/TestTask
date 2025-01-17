<?php

namespace App\Models;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $createdAt,
        public string $password,
    ) {
    }
}
