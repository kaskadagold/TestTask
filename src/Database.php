<?php

namespace App;

use App\Config;

class Database
{
    private array $connectionData;

    public function __construct()
    {
        $this->connectionData = (new Config(APP_DIR . DIRECTORY_SEPARATOR . 'config'))->load()->get('database');
    }

    public function connect(): \PDO
    {
        static $connection = null;

        if ($connection !== null) {
            return $connection;
        }

        $dsn = 'mysql:host=' . $this->connectionData['hostname']
            . ';dbname=' . $this->connectionData['database']
        ;

        $connection = new \PDO(
            $dsn,
            $this->connectionData['username'],
            $this->connectionData['user_pass'],
        );

        return $connection;
    }
}
