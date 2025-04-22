<?php
/**
 * Шаблон просмотра задачи
 * 
 * @var array $task Данные задачи
 */
?>

<h2>Просмотр задачи</h2>

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><?= e($task['title']) ?></h5>
        <p class="card-text"><strong>Описание:</strong> <?= e($task['description'] ?? 'Нет описания') ?></p>
        <p class="card-text"><strong>Категория:</strong> <?= e($task['category_name'] ?? 'Без категории') ?></p>
        <p class="card-text"><strong>Статус:</strong> <?= e($task['status']) ?></p>
        <p class="card-text"><strong>Дата создания:</strong> <?= e($task['created_at']) ?></p>
        <a href="/?action=edit&id=<?= $task['id'] ?>" class="btn btn-primary">Редактировать</a>
        <a href="/?action=list" class="btn btn-secondary">Назад</a>
    </div>
</div>