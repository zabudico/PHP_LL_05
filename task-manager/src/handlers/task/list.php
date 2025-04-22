<?php
/**
 * Обработчик получения списка задач
 */

try {
    $pdo = getDbConnection();

    $stmt = $pdo->query("
        SELECT t.*, c.name as category_name
        FROM tasks t
        LEFT JOIN categories c ON t.category_id = c.id
        ORDER BY t.created_at DESC
    ");
    $tasks = $stmt->fetchAll();

    render('task/list', ['tasks' => $tasks]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка получения списка задач: ' . $e->getMessage());
}