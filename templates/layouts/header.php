<?php
/** 
 * @var ?string $pageTitle
 * @var ?string $headerTitle
 * @var bool $isAuthorized
 * @var ?bool $isLoginPage
 */

$pageTitle ??= 'Тестовое приложение';
$headerTitle ??= $pageTitle;
$isLoginPage ??= false;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($pageTitle) . ' - ' . htmlspecialchars($headerTitle) ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <div class="flex content-between">
        <h3><?= htmlspecialchars($headerTitle) ?></h3>

        <?php 
        if (! $isLoginPage) {
            if (! $isAuthorized) { ?>
                <a href="/login">
                    Войти
                </a>
            <?php 
            } else { 
            ?>
                <div>
                    <form action="/logout" method="post">
                        <input type="submit" name="logout" value="Выйти">
                    </form>
                </div>
            <?php 
            }
        }
        ?>
    </div>
    
