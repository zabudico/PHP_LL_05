<?php
/**
 * Обработчик редактирования задачи
 * 
 * @throws PDOException При ошибках работы с базой данных
 */
function handleTaskEdit(): void
{
    $pdo = getDbConnection();
    $id = (int) ($_GET['id'] ?? 0);

    if ($id <= 0) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    // Загрузка существующих данных
    try {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $task = $stmt->fetch();

        if (!$task) {
            renderError(404, 'Задача не найдена');
            exit;
        }

    } catch (PDOException $e) {
        throw new PDOException("Ошибка загрузки задачи: " . $e->getMessage());
    }

    // Обработка формы
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'category_id' => (int) ($_POST['category_id'] ?? 0),
            'priority' => (int) ($_POST['priority'] ?? 1),
            'status' => isset($_POST['status']) ? 1 : 0
        ];

        $errors = validateTask($data);

        if (empty($errors)) {
            try {
                $stmt = $pdo->prepare("
                    UPDATE tasks SET
                        title = :title,
                        description = :description,
                        category_id = :category,
                        priority = :priority,
                        status = :status
                    WHERE id = :id
                ");

                $stmt->execute([
                    ':title' => $data['title'],
                    ':description' => $data['description'],
                    ':category' => $data['category_id'],
                    ':priority' => $data['priority'],
                    ':status' => $data['status'],
                    ':id' => $id
                ]);

                redirect("/?action=show&id={$id}");

            } catch (PDOException $e) {
                throw new PDOException("Ошибка обновления задачи: " . $e->getMessage());
            }
        }
    }

    $categories = $pdo->query("SELECT * FROM categories")->fetchAll();
    render('task/edit', [
        'task' => $task,
        'categories' => $categories,
        'errors' => $errors ?? [],
        'formData' => $data ?? $task
    ]);
}

handleTaskEdit();