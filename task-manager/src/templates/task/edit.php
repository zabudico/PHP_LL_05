<?php
/**
 * Шаблон редактирования задачи
 * 
 * @var array $task Данные задачи
 * @var array $categories Список категорий
 * @var string|null $error Сообщение об ошибке (если есть)
 */
?>

<h2>Редактировать задачу</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= e($error) ?>
    </div>
<?php endif; ?>

<form action="/?action=edit&id=<?= $task['id'] ?>" method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Название *</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= e($task['title']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea name="description" id="description"
            class="form-control"><?= e($task['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Категория</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="0">Без категории</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= $category['id'] == $task['category_id'] ? 'selected' : '' ?>>
                    <?= e($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Статус</label>
        <select name="status" id="status" class="form-control">
            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>В ожидании</option>
            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Завершено</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
    <a href="/?action=list" class="btn btn-secondary">Отмена</a>
</form>