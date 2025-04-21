<?php
http_response_code(400);
$title = 'Ошибка запроса';
ob_start();
?>
<div class="container mt-5">
    <div class="alert alert-danger">
        <h2>400 — Неверный запрос</h2>
        <p><?= e($message ?? 'Проверьте правильность введенных данных') ?></p>
        <a href="/" class="btn btn-primary">На главную</a>
    </div>
</div>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>