<?php
/**
 * Обработчик редактирования задачи
 */

try {
    $id = (int) ($_GET['id'] ?? 0);
    if ($id <= 0) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    $pdo = getDbConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = (int) ($_POST['category_id'] ?? 0);
        $status = $_POST['status'] ?? 'pending';

        if (empty($title)) {
            render('task/edit', ['error' => 'Название задачи обязательно', 'id' => $id]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, category_id = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $description, $category_id, $status, $id]);

        header('Location: /?action=list');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch();

    if (!$task) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    $stmt = $pdo->query("SELECT * FROM categories");
    $categories = $stmt->fetchAll();

    render('task/edit', ['task' => $task, 'categories' => $categories]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка редактирования задачи: ' . $e->getMessage());
}