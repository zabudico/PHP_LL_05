<?php
/**
 * Шаблон страницы списка задач
 * 
 * @var array $tasks Массив задач
 * @var int $currentPage Текущая страница
 * @var int $totalPages Всего страниц
 */
$title = 'Список задач';
ob_start();
?>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Список задач</h1>
        <a href="/?action=create" class="btn btn-primary">
            + Новая задача
        </a>
    </div>

    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">
            Задачи не найдены. Создайте первую задачу!
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title">
                                    <?= e($task['title']) ?>
                                </h5>
                                <span class="badge bg-<?= match ($task['priority']) {
                                    1 => 'success',
                                    2 => 'warning',
                                    3 => 'danger',
                                    default => 'secondary'
                                } ?>">
                                    Приоритет: <?= $task['priority'] ?>
                                </span>
                            </div>

                            <p class="card-text text-muted small">
                                <?= nl2br(e(truncateText($task['description'], 100))) ?>
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <?= date('d.m.Y H:i', strtotime($task['created_at'])) ?>
                                </small>
                                <span class="badge bg-info">
                                    <?= e($task['category_name']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                            <a href="/?action=show&id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-primary">
                                👁️ Просмотр
                            </a>
                            <a href="/?action=edit&id=<?= $task['id'] ?>" class="btn btn-sm btn-outline-warning">
                                ✏️ Редактировать
                            </a>
                            <form method="POST" action="/?action=delete">
                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Удалить задачу?')">
                                    🗑️ Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Пагинация -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Навигация по страницам">
                <ul class="pagination justify-content-center">
                    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                        <li class="page-item <?= $page === $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="/?page=<?= $page ?>">
                                <?= $page ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';