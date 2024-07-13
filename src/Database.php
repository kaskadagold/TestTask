<?php

namespace App;

use App\Config;

class Database
{
    public function connect(): \PDO
    {
        static $connection = null;
        $connectionData = $this->getConnectionData();

        if ($connection !== null) {
            return $connection;
        }

        $dsn = 'mysql:host=' . $connectionData['hostname']
            . ';dbname=' . $connectionData['database']
        ;

        $connection = new \PDO(
            $dsn,
            $connectionData['username'],
            $connectionData['user_pass'],
        );

        return $connection;
    }

    private function getConnectionData(): array
    {
        return (new Config(APP_DIR . DIRECTORY_SEPARATOR . 'config'))->load()->get('database');
    }
}
