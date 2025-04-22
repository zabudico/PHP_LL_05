<?php
/**
 * Вспомогательные функции приложения
 */

/**
 * Экранирование данных для предотвращения XSS
 * 
 * @param string $value Строка для экранирования
 * @return string Экранированная строка
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Рендеринг шаблона с передачей данных
 * 
 * @param string $template Путь к шаблону
 * @param array $data Данные для шаблона
 * @param string $layout Путь к макету
 * @return void
 */
function render(string $template, array $data = [], string $layout = 'layout'): void
{
    extract($data);
    ob_start();
    require __DIR__ . "/templates/{$template}.php";
    $content = ob_get_clean();
    require __DIR__ . "/templates/{$layout}.php";
}

/**
 * Рендеринг страницы ошибки
 * 
 * @param int $code Код ошибки (404, 500 и т.д.)
 * @param string $message Сообщение об ошибке
 * @return void
 */
function renderError(int $code, string $message): void
{
    http_response_code($code);
    $template = file_exists(__DIR__ . "/templates/errors/{$code}.php") ? "errors/{$code}" : "errors/error";
    render($template, ['code' => $code, 'message' => $message]);
}