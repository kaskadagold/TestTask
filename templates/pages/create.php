<?php
/** 
 * @var ?string $error
 * @var bool $isAuthorized
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Создание новго пользователя', 'error' => $error, 'isAuthorized' => $isAuthorized]);

if ($error !== null) { 
    View::includeTemplate('blocks/messages/error.php', ['message' => $error]);
}
?>

<div class="block">
    <a href="/">
        <button>Вернуться к списку контактов</button>
    </a>
</div>

<div class="creationForm">
    <form action="/create" method="post">
        <?php View::includeTemplate('forms/concrete-form-fields/user-form-fields.php') ?>

        <input type="submit" name="userCreate" value="Добавить">
    </form>
</div>

<?php
View::includeTemplate('layouts/footer.php');