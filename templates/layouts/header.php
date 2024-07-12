<?php
/** 
 * @var ?string $pageTitle
 * @var ?string $headerTitle
 */

$pageTitle ??= 'Тестовое приложение';
$headerTitle ??= $pageTitle;
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($pageTitle) . ' - ' . htmlspecialchars($headerTitle) ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>

<body>
    <h3><?= htmlspecialchars($headerTitle) ?></h3>
