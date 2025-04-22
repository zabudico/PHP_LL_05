<?php
/**
 * Единая точка входа приложения
 * 
 * @package TaskManager
 */

declare(strict_types=1); // Включение строгой типизации

require_once __DIR__ . '/../src/helpers.php';
require_once __DIR__ . '/../src/db.php';

try {
    // Обработка базовых настроек
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();

    // Валидация действия
    $action = $_GET['action'] ?? 'list';
    $action = preg_replace('/[^a-z0-9\-_]/', '', (string) $action); // Санитизация

    // Определение пути к обработчику
    $handlerPath = __DIR__ . "/../src/handlers/task/{$action}.php";

    if (!file_exists($handlerPath)) {
        renderError(404, 'Страница не найдена');
        exit;
    }

    // Проверка метода запроса для критических операций
    if (in_array($action, ['delete']) && $_SERVER['REQUEST_METHOD'] !== 'POST') {
        renderError(405, 'Метод не разрешен');
        exit;
    }

    // Подключение обработчика
    require $handlerPath;

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
    renderError(500, 'Ошибка базы данных');
} catch (Throwable $e) {
    error_log('Unexpected error: ' . $e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
    renderError(500, 'Внутренняя ошибка сервера');
}