<?php
/**
 * Базовый шаблон лейаута
 * 
 * @var string $title Заголовок страницы
 * @var string $content Контент страницы
 */
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title><?= e($title ?? 'Task Manager') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Task Manager</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/?action=create">Новая задача</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>
</body>

</html>