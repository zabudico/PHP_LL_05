<?php
/** 
 * Шаблон страницы просмотра задачи
 * 
 * @var array $task Данные задачи
 */
$title = e($task['title']);
ob_start();
?>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h2><?= e($task['title']) ?></h2>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5>Описание</h5>
                    <p><?= nl2br(e($task['description'])) ?></p>
                </div>

                <div class="col-md-4">
                    <div class="mb-4">
                        <h5>Детали</h5>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Категория:</strong>
                                <?= e($task['category_name']) ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Приоритет:</strong>
                                <?= match ($task['priority']) {
                                    1 => 'Низкий',
                                    2 => 'Средний',
                                    3 => 'Высокий'
                                } ?>
                            </li>
                            <li class="list-group-item">
                                <strong>Статус:</strong>
                                <?= $task['status'] ? '✅ Завершено' : '🟡 В процессе' ?>
                            </li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="/?action=edit&id=<?= $task['id'] ?>" class="btn btn-primary">
                            Редактировать
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';