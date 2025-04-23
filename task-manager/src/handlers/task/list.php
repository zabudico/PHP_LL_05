<?php
/**
 * Обработчик получения списка задач с пагинацией
 * 
 * Этот обработчик извлекает список задач из базы данных с учетом пагинации
 * (по 5 задач на странице) и передает их в шаблон для отображения.
 * 
 * @throws PDOException При ошибках базы данных
 */
try {
    $pdo = getDbConnection();

    // Количество задач на странице
    $tasksPerPage = 5;

    // Получение текущей страницы из GET-параметра (по умолчанию 1)
    $currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

    // Вычисление смещения (OFFSET)
    $offset = ($currentPage - 1) * $tasksPerPage;

    // Подсчет общего количества задач
    $stmt = $pdo->query("SELECT COUNT(*) FROM tasks");
    $totalTasks = $stmt->fetchColumn();
    $totalPages = ceil($totalTasks / $tasksPerPage);

    // Отладка: логируем количество задач
    error_log("Общее количество задач: $totalTasks");

    // Выборка задач с учетом пагинации
    $stmt = $pdo->prepare("
        SELECT t.*, c.name as category_name
        FROM tasks t
        LEFT JOIN categories c ON t.category_id = c.id
        ORDER BY t.created_at DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->execute([$tasksPerPage, $offset]);
    $tasks = $stmt->fetchAll();

    // Отладка: логируем количество возвращенных задач
    error_log("Количество задач на странице $currentPage: " . count($tasks));

    // Передача данных в шаблон
    render('task/list', [
        'tasks' => $tasks,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка получения списка задач: ' . $e->getMessage());
}