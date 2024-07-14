<?php
/**
 * @var ?string $inputId
 * @var ?string $label
 * @var ?string $type
 * @var ?string $placeholder
 * @var ?string $inputName
 * @var ?string $value
 */

$type ??= 'text';
$value ??= '';
$placeholder ??= '';
?>

<div class="my-10">
    <label for="<?= $inputId ?>" class="block"><?= $label ?></label>
    <input 
        type="<?= $type ?>"
        placeholder="<?= $placeholder ?>"
        id="<?= $inputId ?>"
        name="<?= $inputName ?>"
        value="<?= $value ?>"
    >
</div>
