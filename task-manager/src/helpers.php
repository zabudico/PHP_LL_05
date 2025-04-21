<?php
/**
 * Экранирует HTML-сущности
 * 
 * @param string $value Входная строка
 * @return string Очищенная строка
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Рендерит шаблон с использованием лейаута
 * 
 * @param string $template Название шаблона (без расширения)
 * @param array $data Данные для передачи в шаблон
 */
function render(string $template, array $data = []): void
{
    extract($data);
    ob_start();
    include __DIR__ . "/templates/{$template}.php";
    $content = ob_get_clean();
    include __DIR__ . '/templates/layout.php';
}

/**
 * Выполняет редирект на указанный URL
 * 
 * @param string $url Целевой URL
 */
function redirect(string $url): void
{
    header("Location: {$url}");
    exit;
}

/**
 * Валидирует данные задачи
 * 
 * @param array $data Массив данных формы
 * @return array Массив ошибок валидации
 */
function validateTask(array $data): array
{
    $errors = [];

    // Валидация названия
    if (empty(trim($data['title'] ?? ''))) {
        $errors['title'] = 'Название обязательно';
    } elseif (mb_strlen($data['title']) > 255) {
        $errors['title'] = 'Название не должно превышать 255 символов';
    }

    // Валидация категории
    if (!isset($data['category_id']) || !is_numeric($data['category_id'])) {
        $errors['category'] = 'Неверная категория';
    }

    return $errors;
}

/**
 * Рендерит страницу ошибки
 * 
 * @param int $statusCode HTTP-код статуса
 * @param string $message Сообщение об ошибке
 */
function renderError(int $statusCode, string $message): void
{
    http_response_code($statusCode);
    render("errors/{$statusCode}", ['message' => $message]);
    exit;
}

/**
 * Обрезает текст до указанной длины
 * 
 * @param string $text Исходный текст
 * @param int $length Максимальная длина
 * @return string Обрезанный текст
 */
function truncateText(string $text, int $length = 100): string
{
    if (mb_strlen($text) > $length) {
        return mb_substr($text, 0, $length) . '...';
    }
    return $text;
}