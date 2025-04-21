<?php
/**
 * Обработчик просмотра деталей задачи
 * 
 * @throws PDOException При ошибках работы с базой данных
 */
function handleTaskShow(): void
{
    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        renderError(400, 'Неверный ID задачи');
    }

    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("
            SELECT t.*, c.name AS category_name 
            FROM tasks t
            JOIN categories c ON t.category_id = c.id
            WHERE t.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $task = $stmt->fetch();

        if (!$task) {
            renderError(404, 'Задача не найдена');
        }

        render('task/show', ['task' => $task]);

    } catch (PDOException $e) {
        error_log($e->getMessage());
        renderError(500, 'Ошибка при загрузке задачи');
    }
}

handleTaskShow();