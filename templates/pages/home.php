<?php
/** 
 * @var ?array $users
 * @var ?string $success
 * @var ?string $error
 * @var bool $isAuthorized
 * @var bool $isAdmin
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Список пользователей', 'isAuthorized' => $isAuthorized]);

if ($success !== null) {
    View::includeTemplate('blocks/messages/success.php', ['message' => $success]);
}

if ($error !== null) {
    View::includeTemplate('blocks/messages/error.php', ['message' => $error]);
}

if ($isAdmin) {
?>
<div class="block my-10">
    <a href="/create">
        <button>Добавить нового пользователя</button>
    </a>
</div>
<?php } ?>

<div class="table">

    <?php if (empty($users)) {?>
        <p>Нет сохраненных контактов...</p>
    <?php } else { ?>
        <table>
            <tr>
                <?php if ($isAdmin) { ?>
                    <th class="deleteButton">Удалить</th>
                <?php } ?>
                <th class="nameField">Имя</th>
                <th class="phoneField">Email</th>
            <tr>

            <?php foreach ($users as $user) { ?>
                <tr>
                    <?php if ($isAdmin) { ?>
                        <td>
                            <form action="/delete/<?= $user->id ?>" method="post">
                                <button class="image-button">
                                    <img src="/assets/images/recycle-bin.png" alt="Удалить" title="Удалить">
                                </button>
                            </form>
                        </td>
                    <?php } ?>
                    <td class="nameField"><?= $user->name ?></td>
                    <td class="phoneField"><?= $user->email ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>

<?php
View::includeTemplate('layouts/footer.php');
