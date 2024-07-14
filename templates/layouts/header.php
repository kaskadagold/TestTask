<?php
/** 
 * @var ?string $pageTitle
 * @var ?string $headerTitle
 * @var bool $isAuthorized
 * @var string $userName
 * @var ?bool $isLoginShown
 */

$pageTitle ??= 'Тестовое приложение';
$headerTitle ??= $pageTitle;
$isLoginShown ??= true;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/assets/css/styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="/assets/js/delete.js"></script>

    <title><?= htmlspecialchars($pageTitle) . ' - ' . htmlspecialchars($headerTitle) ?></title>
</head>

<body class="ml-20">
    <div class="flex content-between items-center">
        <h2><?= htmlspecialchars($headerTitle) ?></h2>

        <?php 
        if ($isLoginShown) {
            if (! $isAuthorized) { ?>
                <a href="/login" class="mr-20">
                    Войти
                </a>
            <?php 
            } else { 
            ?>
                <nav class="flex items-center mr-20">
                    <p class="mx-10"><?= $userName ?></p>
                    <form action="/logout" method="post" class="mx-10">
                        <input type="submit" name="logout" value="Выйти">
                    </form>
                </nav>
            <?php 
            }
        }
        ?>
    </div>
