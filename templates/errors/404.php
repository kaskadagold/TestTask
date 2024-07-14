<?php
/**
 * @var string $message
 * @var int $code
 */

use App\View;

View::includeTemplate('layouts/header.php', ['headerTitle' => $message, 'isLoginShown' => false]);
?>

<p>Запрошенной страницы не существует</p>

<?php
View::includeTemplate('layouts/footer.php');
