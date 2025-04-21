<?php
/**
 * Обработчик отображения списка задач с пагинацией
 * 
 * @throws PDOException При ошибках работы с базой данных
 */
function handleTaskList(): void
{
    $pdo = getDbConnection();

    // Пагинация
    $currentPage = max(1, (int) ($_GET['page'] ?? 1));
    $perPage = 5;
    $offset = ($currentPage - 1) * $perPage;

    try {
        // Получение задач
        $stmt = $pdo->prepare("
            SELECT t.*, c.name AS category_name 
            FROM tasks t
            JOIN categories c ON t.category_id = c.id
            ORDER BY t.created_at DESC
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll();

        // Подсчет общего количества
        $totalTasks = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
        $totalPages = (int) ceil($totalTasks / $perPage);

    } catch (PDOException $e) {
        throw new PDOException("Ошибка загрузки задач: " . $e->getMessage());
    }

    render('task/list', [
        'tasks' => $tasks,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ]);
}

handleTaskList();