<?php
/**
 * Шаблон создания новой задачи
 * 
 * @var array $categories Список категорий
 * @var array $validStatuses Список допустимых статусов
 * @var string|null $error Сообщение об ошибке (если есть)
 */
?>

<h2>Новая задача</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<form action="/?action=create" method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Название *</label>
        <input type="text" name="title" id="title" class="form-control"
            value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea name="description" id="description"
            class="form-control"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Категория</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="0">Без категории</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= (isset($_POST['category_id']) && (int) $_POST['category_id'] === $category['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Статус *</label>
        <select name="status" id="status" class="form-control" required>
            <?php foreach ($validStatuses as $status): ?>
                <option value="<?= $status ?>" <?= (isset($_POST['status']) && $_POST['status'] === $status) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Создать</button>
</form>