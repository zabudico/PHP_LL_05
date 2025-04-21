<?php
return [
    'host' => $_ENV['DB_HOST'] ?? 'mysql',
    'dbname' => $_ENV['DB_NAME'] ?? 'task_manager',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? 'secret',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
];