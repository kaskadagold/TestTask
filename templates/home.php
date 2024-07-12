<?php
/** @var ?array $users */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Список пользователей']);
?>

<div class="block my-10">
    <a href="/create">
        <button>Добавить нового пользователя</button>
    </a>
</div>

<div class="table">

    <?php if (empty($users)) {?>
        <p>Нет сохраненных контактов...</p>
    <?php } else { ?>
        <table>
            <tr>
                <th class="deleteButton">Удалить</th>
                <th class="nameField">Имя</th>
                <th class="phoneField">Email</th>
            <tr>

            <?php foreach ($users as $user) { ?>
                <tr>
                    <td>
                        <form action="/delete/<?= $user->id ?>" method="post">
                            <button class="image-button">
                                <img src="/assets/images/recycle-bin.png" alt="Удалить" title="Удалить">
                            </button>
                        </form>
                    </td>
                    <td class="nameField"><?= $user->name ?></td>
                    <td class="phoneField"><?= $user->email ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>

<?php
View::includeTemplate('layouts/footer.php');
