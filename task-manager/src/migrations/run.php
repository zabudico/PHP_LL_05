<?php
/**
 * Скрипт выполнения миграций
 * 
 * @throws PDOException При ошибках выполнения SQL
 */
require __DIR__ . '/../config/bootstrap.php';

try {
    $pdo = getDbConnection();

    // Отключение проверки внешних ключей
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');

    $migrations = glob(__DIR__ . '/*.sql');

    foreach ($migrations as $file) {
        echo "Applying: " . basename($file) . "\n";
        $sql = file_get_contents($file);
        $pdo->exec($sql);
    }

    // Включение проверки внешних ключей
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');

    echo "Все миграции успешно применены\n";

} catch (PDOException $e) {
    die("Ошибка миграции: " . $e->getMessage());
}