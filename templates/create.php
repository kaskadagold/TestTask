<?php
/** @var ?string $error */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Создание новго пользователя', 'error' => $error]);

if ($error !== null) { 
?>
    <p style="color:red"><?= $error ?><p>
<?php } ?>

<div class="block">
    <a href="/">
        <button>Вернуться к списку контактов</button>
    </a>
</div>

<div class="creationForm">
    <form action="/create" method="post">
        <?php View::includeTemplate('blocks/user-form-fields.php') ?>

        <input type="submit" name="addButton" value="Добавить">
    </form>
</div>

<?php
View::includeTemplate('layouts/footer.php');
