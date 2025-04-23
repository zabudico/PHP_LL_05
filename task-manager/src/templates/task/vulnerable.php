<?php
/**
 * Шаблон для демонстрации уязвимого поиска задач
 * 
 * @var array $tasks Список найденных задач
 * @var string|null $error Сообщение об ошибке (если есть)
 */
?>

<h2>Поиск задач (уязвимый)</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/?action=vulnerable" method="GET">
    <div class="mb-3">
        <label for="title" class="form-label">Поиск по заголовку</label>
        <input type="text" name="title" id="title" class="form-control"
            value="<?= htmlspecialchars($_GET['title'] ?? '') ?>">
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
</form>

<?php if (!empty($tasks)): ?>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Название</th>
                <th>Категория</th>
                <th>Статус</th>
                <th>Дата создания</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title'] ?? 'Без названия') ?></td>
                    <td><?= htmlspecialchars($task['category_name'] ?? 'Без категории') ?></td>
                    <td><?= htmlspecialchars($task['status'] ?? 'Не указан') ?></td>
                    <td><?= htmlspecialchars($task['created_at'] ?? 'Неизвестно') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>