<?php
require_once __DIR__ . '/src/Config.php';

$config = (new \App\Config(__DIR__ . DIRECTORY_SEPARATOR . 'config'))->load();
$data = $config->get('database');

$connection = new \PDO(
    'mysql:host=' . $data['hostname'],
    $data['root_username'],
    $data['root_password'],
);

$hostname = $data['hostname'];
$database = $data['database'];
$charset = $data['charset'];
$collation = $data['collation'];
$userName = $data['username'];
$userPass = $data['user_pass'];

$connection->exec(
    "CREATE DATABASE IF NOT EXISTS `$database` 
    CHARACTER SET $charset
    COLLATE $collation;
    DROP USER '$userName'@'$hostname';
    FLUSH PRIVILEGES;
    CREATE USER '$userName'@'$hostname' IDENTIFIED BY '$userPass';
    GRANT ALL PRIVILEGES ON `$database`.* TO '$userName'@'$hostname';
    FLUSH PRIVILEGES;"
);

unset($connection);

$adminName = $config->get('admin.name');
$adminEmail = $config->get('admin.email');
$adminPass = $config->get('admin.password');

$connection = new \PDO(
    'mysql:host=' . $hostname . ';dbname=' . $database,
    $userName,
    $userPass,
);

$connection->exec(
    "DROP TABLE IF EXISTS `users`;
    CREATE TABLE `users` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL UNIQUE,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `created_at` TIMESTAMP DEFAULT NOW() NOT NULL,
        `password` VARCHAR(255) NOT NULL
    );
    INSERT INTO `users` (`name`, `email`, `password`)
    VALUES ('{$adminName}', '{$adminEmail}', '{$adminPass}');"
);

unset($connection);
