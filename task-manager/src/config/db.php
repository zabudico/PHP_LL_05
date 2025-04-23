<?php
return [
    'host' => getenv('DB_HOST') ?: 'mysql',
    'dbname' => getenv('DB_NAME') ?: 'task_manager',
    'username' => getenv('DB_USER') ?: 'user',
    'password' => getenv('DB_PASS') ?: 'secret',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];