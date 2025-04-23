<?php
/**
 * Подключение к базе данных
 * 
 * @return PDO Экземпляр PDO для работы с базой данных
 * @throws PDOException При ошибке подключения
 */
function getDbConnection()
{
    $config = require __DIR__ . '/config/db.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        // Проверка подключения
        $pdo->query("SELECT 1");
        return $pdo;
    } catch (PDOException $e) {
        // Логирование ошибки для отладки
        error_log("Ошибка подключения к базе данных: " . $e->getMessage());
        throw $e;
    }
}