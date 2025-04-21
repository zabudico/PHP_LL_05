<?php
/**
 * Шаблон страницы редактирования задачи
 * 
 * @var array $task Данные задачи
 * @var array $categories Список категорий
 * @var array $errors Ошибки валидации
 * @var array $formData Введенные данные формы
 */
$title = 'Редактирование задачи: ' . e($task['title']);
ob_start();
?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h2>Редактирование задачи</h2>
        </div>
        
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Название *</label>
                    <input type="text" name="title" 
                           class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>"
                           value="<?= e($formData['title'] ?? $task['title']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea name="description" 
                              class="form-control"
                              rows="4"><?= e($formData['description'] ?? $task['description']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Категория *</label>
                            <select name="category_id" 
                                    class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>"
                                    required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"
                                        <?= ($formData['category_id'] ?? $task['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                        <?= e($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Статус</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="status" 
                                       value="1"
                                       <?= ($formData['status'] ?? $task['status']) ? 'checked' : '' ?>>
                                <label class="form-check-label">Завершено</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/?action=show&id=<?= $task['id'] ?>" class="btn btn-secondary">Отмена</a>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__.'/../layout.php';