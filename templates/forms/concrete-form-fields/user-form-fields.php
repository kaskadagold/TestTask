<?php

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'userName',
    'label' => 'Имя:',
    'placeholder' => 'Имя',
    'inputName' => 'name',
]);

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'userEmail',
    'label' => 'Email:',
    'type' => 'email',
    'placeholder' => 'example@example.com',
    'inputName' => 'email',
]);

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'userPassword',
    'label' => 'Пароль:',
    'type' => 'password',
    'placeholder' => '******',
    'inputName' => 'password',
]);

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'userPasswordConfirmation',
    'label' => 'Подтверждение пароля:',
    'type' => 'password',
    'placeholder' => '******',
    'inputName' => 'password_confirmation',
]);
