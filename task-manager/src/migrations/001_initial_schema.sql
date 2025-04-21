-- Удаление таблиц если они существуют
DROP TABLE IF EXISTS tasks;
DROP TABLE IF EXISTS categories;

-- Создание таблицы категорий
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Создание таблицы задач
CREATE TABLE tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Вставка данных с обработкой дубликатов
INSERT IGNORE INTO categories (name) VALUES 
('Работа'), 
('Личное'), 
('Учеба');