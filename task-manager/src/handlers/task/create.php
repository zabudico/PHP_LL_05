<?php
/**
 * Обработчик создания новой задачи
 * 
 * Этот обработчик обрабатывает GET-запрос для отображения формы создания задачи
 * и POST-запрос для сохранения новой задачи в базе данных.
 * 
 * @throws PDOException При ошибках évident базы данных
 */
try {
    // Define valid status options
    $validStatuses = ['Pending', 'In Progress', 'Completed'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category_id = (int) ($_POST['category_id'] ?? 0);
        $status = trim($_POST['status'] ?? 'Pending'); // Default to 'Pending'

        // Validate input
        if (empty($title)) {
            render('task/create', [
                'error' => 'Название задачи обязательно',
                'categories' => getCategories(),
                'validStatuses' => $validStatuses
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

        // Validate status
        if (!in_array($status, $validStatuses)) {
            $status = 'Pending'; // Fallback to default if invalid
        }

        // Insert task into the database
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("
            INSERT INTO tasks (title, description, category_id, status, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->execute([$title, $description, $category_id, $status]);

        // Redirect to task list
        header('Location: /?action=list');
        exit;
    }

    // Fetch categories for the form
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT id, name FROM categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Render the task creation form
    render('task/create', [
        'categories' => $categories,
        'validStatuses' => $validStatuses
    ]);

} catch (PDOException $e) {
    renderError(500, 'Ошибка создания задачи: ' . $e->getMessage());
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