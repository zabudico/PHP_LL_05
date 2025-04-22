<?php
/**
 * Создает и возвращает подключение к базе данных
 * 
 * @return PDO Объект PDO для работы с базой данных
 * @throws PDOException Если подключение не удалось
 */
function getDbConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $config = require __DIR__ . '/config/db.php';

        $maxAttempts = 10;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            try {
                $pdo = new PDO(
                    "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
                break; // Успешное подключение, выходим из цикла
            } catch (PDOException $e) {
                if ($attempt === $maxAttempts - 1) {
                    throw new PDOException("Connection failed after $maxAttempts attempts: " . $e->getMessage());
                }
                $attempt++;
                sleep(1); // Ждем 1 секунду перед следующей попыткой
            }
        }
    }

    return $pdo;
}