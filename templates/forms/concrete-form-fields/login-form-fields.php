<?php

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'loginName',
    'label' => 'Логин (имя):',
    'placeholder' => 'Имя',
    'inputName' => 'name',
]);

\App\View::includeTemplate('forms/input.php', [
    'inputId' => 'loginPassword',
    'label' => 'Пароль:',
    'type' => 'password',
    'placeholder' => '******',
    'inputName' => 'password',
]);
