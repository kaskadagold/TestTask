<?php
/** 
 * @var ?string $error
 * @var bool $isLoginPage
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Авторизация', 'isLoginPage' => $isLoginPage]);

if ($error !== null) {
    View::includeTemplate('blocks/messages/error.php', ['message' => $error]);
}
?>

<div class="block">
    <form action="/login" method="post">
        <?php View::includeTemplate('forms/concrete-form-fields/login-form-fields.php'); ?>

        <input type="submit" name="login" value="Войти">
        <a href="/" class="mx-10">Отмена</a>
    </form>
</div>

<?php
View::includeTemplate('layouts/footer.php');
