<?php
/**
 * Обработчик удаления задачи
 * 
 * @throws PDOException При ошибках работы с базой данных
 */
function handleTaskDelete(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        renderError(405, 'Метод не поддерживается');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) {
        renderError(400, 'Неверный ID задачи');
    }

    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() === 0) {
            renderError(404, 'Задача не найдена');
        }

        redirect('/?action=list');

    } catch (PDOException $e) {
        throw new PDOException("Ошибка удаления задачи: " . $e->getMessage());
    }
}

handleTaskDelete();