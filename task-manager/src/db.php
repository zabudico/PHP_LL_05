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

        try {
            $pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    return $pdo;
}