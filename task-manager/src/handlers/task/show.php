<?php
/**
 * Обработчик просмотра задачи
 * 
 * Этот обработчик извлекает данные одной задачи по ID и отображает их в шаблоне.
 * 
 * @throws PDOException При ошибках базы данных
 */
try {
    $id = (int) ($_GET['id'] ?? 0);
    if ($id <= 0) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("
        SELECT t.*, c.name as category_name
        FROM tasks t
        LEFT JOIN categories c ON t.category_id = c.id
        WHERE t.id = ?
    ");
    $stmt->execute([$id]);
    $task = $stmt->fetch();

    if (!$task) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    render('task/show', ['task' => $task]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка просмотра задачи: ' . $e->getMessage());
}