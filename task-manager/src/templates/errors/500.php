<?php
http_response_code(500);
$title = 'Ошибка сервера';
ob_start();
?>
<div class="container mt-5">
    <div class="alert alert-danger">
        <h2>500 — Внутренняя ошибка сервера</h2>
        <p><?= e($message ?? 'Попробуйте обновить страницу позже') ?></p>
        <a href="/" class="btn btn-primary">На главную</a>
    </div>
</div>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>