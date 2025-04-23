<?php
/**
 * Уязвимый обработчик для демонстрации SQL-инъекции
 * 
 * Этот обработчик принимает параметр title из GET-запроса и выполняет
 * поиск задач по заголовку без использования подготовленных выражений.
 * 
 * @throws PDOException При ошибках базы данных
 */
try {
    // Получение заголовка из GET-параметра (без валидации)
    $title = $_GET['title'] ?? '';

    if (empty($title)) {
        render('task/vulnerable', ['error' => 'Введите заголовок для поиска']);
        exit;
    }

    // Уязвимый SQL-запрос (прямая вставка данных)
    $pdo = getDbConnection();
    $query = "SELECT * FROM tasks WHERE title = '$title'";
    $stmt = $pdo->query($query);
    $tasks = $stmt->fetchAll();

    render('task/vulnerable', ['tasks' => $tasks]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка поиска задач: ' . $e->getMessage());
}