<?php
/**
 * @var string $message
 * @var int $code
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => $message, 'isLoginShown' => false]);
?>

<p>Код ошибки: <?= $code ?></p>
<p>Сообщение: <?= $message ?></p>

<?php
View::includeTemplate('layouts/footer.php');
