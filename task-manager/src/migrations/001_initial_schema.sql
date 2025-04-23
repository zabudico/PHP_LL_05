-- Удаление таблиц если они существуют
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS categories;

-- Создание таблицы категорий
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Создание таблицы задач с добавленным столбцом status
CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT UNSIGNED NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending', -- Добавленный столбец
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Вставка данных с обработкой дубликатов
INSERT IGNORE INTO categories (name) VALUES 
('Работа'), 
('Личное'), 
('Учеба');













/*
-- Вставка тестовых данных в таблицу categories
INSERT INTO categories (name, created_at) VALUES
('Работа', NOW()),
('Личное', NOW()),
('Учеба', NOW());
*/



-- Вставка тестовых данных в таблицу tasks
INSERT INTO tasks (title, description, category_id, status, created_at) VALUES
('Завершить отчет', 'Подготовить ежемесячный отчет по проекту', 1, 'Pending', NOW()),
('Купить продукты', 'Список: молоко, хлеб, яйца', 2, 'Completed', NOW()),
('Подготовиться к экзамену', 'Изучить материалы по математике', 3, 'In Progress', NOW()),
('Встреча с клиентом', 'Обсудить детали нового проекта', 1, 'Pending', NOW()),
('Прогулка с собакой', 'Пройтись по парку', 2, 'Completed', NOW());



INSERT INTO tasks (title, description, category_id, status, created_at) VALUES
('Задача 1', 'Описание 1', 1, 'Pending', NOW()),
('Задача 2', 'Описание 2', 1, 'In Progress', NOW()),
('Задача 3', 'Описание 3', 2, 'Completed', NOW()),
('Задача 4', 'Описание 4', 2, 'Pending', NOW()),
('Задача 5', 'Описание 5', 3, 'In Progress', NOW()),
('Задача 6', 'Описание 6', 3, 'Completed', NOW()),
('Задача 7', 'Описание 7', 1, 'Pending', NOW());

