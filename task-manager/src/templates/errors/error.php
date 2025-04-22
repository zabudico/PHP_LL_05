<?php
/**
 * Общий шаблон ошибки
 * 
 * @var int $code Код ошибки
 * @var string $message Сообщение об ошибке
 */
?>

<h1>Ошибка <?= $code ?></h1>
<p><?= htmlspecialchars($message) ?></p>