<?php
http_response_code(404);
$title = 'Страница не найдена';
ob_start();
?>
<div class="container mt-5">
    <div class="alert alert-warning">
        <h2>404 — Страница не найдена</h2>
        <p><?= e($message ?? 'Запрошенная страница не существует') ?></p>
        <a href="/" class="btn btn-primary">На главную</a>
    </div>
</div>
<?php $content = ob_get_clean();
include __DIR__ . '/../layout.php'; ?>