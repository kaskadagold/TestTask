<?php
/** 
 * @var ?array $users
 * @var ?string $success
 * @var ?string $error
 * @var bool $isAuthorized
 * @var string $userName
 * @var bool $isAdmin
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => 'Список пользователей', 'isAuthorized' => $isAuthorized, 'userName' => $userName]);

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
                    <th>Удалить</th>
                <?php } ?>
                <th>Имя</th>
                <th>Email</th>
            <tr>

            <?php foreach ($users as $user) { ?>
                <tr id="user<?= $user->id ?>">
                    <?php if ($isAdmin) { ?>
                        <td>
                            <!-- Удаление пользователя с помощью AJAX запроса -->
                            <button name="deleteButton" class="image-button" value="<?= $user->id ?>">
                                <img src="/assets/images/recycle-bin.png" alt="Удалить" title="Удалить">
                            </button>

                            <!-- Удаление пользователя без AJAX запроса -->
                            <?php /*
                            <form action="/delete/<?= $user->id ?>" method="post">
                                <button class="image-button">
                                    <img src="/assets/images/recycle-bin.png" alt="Удалить" title="Удалить">
                                </button>
                            </form>
                            */ ?>
                        </td>
                    <?php } ?>
                    <td><?= $user->name ?></td>
                    <td><?= $user->email ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
</div>

<?php
View::includeTemplate('layouts/footer.php');
