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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Task Manager</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/?action=create">Новая задача</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/?action=vulnerable">Уязвимый поиск</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <!-- Подключение JavaScript для Bootstrap (необходимо для пагинации и других интерактивных элементов) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>