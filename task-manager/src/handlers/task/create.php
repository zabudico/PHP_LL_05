<?php
/**
 * Обработчик создания новой задачи
 * 
 * @throws PDOException При ошибках работы с базой данных
 */
function handleTaskCreate(): void
{
    $pdo = getDbConnection();
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'priority' => (int) ($_POST['priority'] ?? 1)
        ];

        $errors = validateTask($data);

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO tasks 
                    (title, description, category_id, priority) 
                    VALUES (:title, :description, :category, :priority)
                ");

                $stmt->execute([
                    ':title' => $data['title'],
                    ':description' => $data['description'],
                    ':category' => $data['category_id'],
                    ':priority' => $data['priority']
                ]);

                redirect('/?action=list');

            } catch (PDOException $e) {
                throw new PDOException("Ошибка создания задачи: " . $e->getMessage());
            }
        }
    }

    $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
    render('task/create', [
        'categories' => $categories,
        'errors' => $errors,
        'formData' => $data ?? []
    ]);
}

handleTaskCreate();