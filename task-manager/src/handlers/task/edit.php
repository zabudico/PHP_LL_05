<?php
/**
 * Обработчик редактирования задачи
 * 
 * Этот обработчик обрабатывает GET-запрос для отображения формы редактирования
 * и POST-запрос для обновления данных задачи в базе данных.
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = (int) ($_POST['category_id'] ?? 0);
        $status = $_POST['status'] ?? 'Pending';

        // Validate input
        if (empty($title)) {
            render('task/edit', [
                'error' => 'Название задачи обязательно',
                'id' => $id,
                'categories' => getCategories()
            ]);
            exit;
        }

        // Validate category_id
        $categories = getCategories();
        $validCategoryIds = array_column($categories, 'id');
        if ($category_id === 0 || !in_array($category_id, $validCategoryIds)) {
            // Если category_id = 0 или недопустим, используем первую категорию
            $category_id = $validCategoryIds[0] ?? 1; // Первая категория или 1 по умолчанию
        }

        // Update task in the database
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, category_id = ?, status = ? WHERE id = ?");
        $stmt->execute([$title, $description, $category_id, $status, $id]);

        header('Location: /?action=list');
        exit;
    }

    // Fetch task for editing
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
    $stmt->execute([$id]);
    $task = $stmt->fetch();

    if (!$task) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    // Fetch categories for the form
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll();

    render('task/edit', [
        'task' => $task,
        'categories' => $categories
    ]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка редактирования задачи: ' . $e->getMessage());
}

/**
 * Получение списка категорий из базы данных
 * 
 * @return array Массив категорий с полями id и name
 * @throws PDOException При ошибках базы данных
 */
function getCategories()
{
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT id, name FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}