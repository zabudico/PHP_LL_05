<?php
/**
 * Обработчик создания новой задачи
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
 * Helper function to fetch categories (for reuse in case of validation error)
 */
function getCategories()
{
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT id, name FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}