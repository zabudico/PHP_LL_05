<?php
/**
 * Шаблон списка задач с пагинацией
 * 
 * @var array $tasks Список задач
 * @var int $currentPage Текущая страница
 * @var int $totalPages Общее количество страниц
 */
?>

<h2>Список задач</h2>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info">
        Задачи не найдены. Создайте первую задачу!
    </div>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Категория</th>
                <th>Статус</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title'] ?? 'Без названия') ?></td>
                    <td><?= htmlspecialchars($task['category_name'] ?? 'Без категории') ?></td>
                    <td><?= htmlspecialchars($task['status'] ?? 'Не указан') ?></td>
                    <td><?= htmlspecialchars($task['created_at'] ?? 'Неизвестно') ?></td>
                    <td>
                        <a href="/?action=show&id=<?= (int) $task['id'] ?>">Просмотр</a>
                        <a href="/?action=edit&id=<?= (int) $task['id'] ?>">Редактировать</a>
                        <form action="/?action=delete" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                            <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Навигация для пагинации -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Предыдущая страница -->
                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="/?action=list&page=<?= $currentPage - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">«</span>
                    </a>
                </li>

                <!-- Номера страниц -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="/?action=list&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Следующая страница -->
                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="/?action=list&page=<?= $currentPage + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
<?php endif; ?>

<a href="/?action=create" class="btn btn-primary">Новая задача</a>