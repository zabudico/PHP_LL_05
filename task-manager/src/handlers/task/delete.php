<?php
/**
 * Обработчик удаления задачи
 * 
 * Этот обработчик удаляет задачу из базы данных по указанному ID.
 * Ожидает POST-запрос с параметром id.
 * 
 * @throws PDOException При ошибках базы данных
 */
try {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id <= 0) {
        renderError(404, 'Задача не найдена');
        exit;
    }

    $pdo = getDbConnection();
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: /?action=list');
    exit;

} catch (PDOException $e) {
    renderError(500, 'Ошибка удаления задачи: ' . $e->getMessage());
}