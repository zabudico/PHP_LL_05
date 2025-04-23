# Task Manager

## Инструкции по запуску проекта

### Требования

- Docker и Docker Compose
- PHP 7.4 или выше (установлен в контейнере)
- MySQL (используется контейнер MySQL)

### Установка и запуск

1. **Клонирование репозитория**:

   ```bash
   git clone <repository-url>
   cd task-manager
   ```

2. **Создание файла `.env`**:
   Создайте файл `.env` в корне проекта со следующими настройками:

   ```env
   DB_HOST=mysql
   DB_NAME=task_manager
   DB_USER=user
   DB_PASS=secret
   ```

3. **Запуск контейнеров**:

   ```bash
   docker-compose up --build
   ```

4. **Выполнение миграций**:

   ```bash
   docker-compose exec php-fpm php /var/www/html/src/migrations/run.php
   ```

5. **Добавление тестовых данных**:
   Подключитесь к MySQL через phpMyAdmin (`http://localhost:8081`) или командную строку:

   ```bash
   docker-compose exec mysql mysql -uuser -psecret task_manager
   ```

   Выполните SQL-запрос для добавления тестовых данных:

   ```sql
   INSERT INTO tasks (title, description, category_id, status, created_at) VALUES
   ('Задача 1', 'Описание 1', 1, 'Pending', NOW()),
   ('Задача 2', 'Описание 2', 1, 'In Progress', NOW()),
   ('Задача 3', 'Описание 3', 2, 'Completed', NOW()),
   ('Задача 4', 'Описание 4', 2, 'Pending', NOW()),
   ('Задача 5', 'Описание 5', 3, 'In Progress', NOW()),
   ('Задача 6', 'Описание 6', 3, 'Completed', NOW()),
   ('Задача 7', 'Описание 7', 1, 'Pending', NOW());
   ```

6. **Доступ к приложению**:
   Откройте в браузере: `http://localhost:8080`.

7. **Проверка логов (при возникновении проблем)**:
   ```bash
   docker-compose exec php-fpm cat /var/log/php_errors.log
   ```

## Описание лабораторной работы

**Цель**: Освоить архитектуру с единой точкой входа, подключение шаблонов для визуализации страниц, а также переход от хранения данных в файле к использованию базы данных (MySQL).

**Задачи**:

1. Реализовать архитектуру с единой точкой входа (`index.php`).
2. Настроить систему шаблонов с использованием `layout.php`.
3. Перенести данные в базу данных MySQL.
4. Реализовать CRUD-операции для задач.
5. Обеспечить защиту от SQL-инъекций.
6. Реализовать пагинацию (5 задач на страницу).

**Тема проекта**: Task Manager — приложение для управления задачами с категориями и статусами. Проект адаптирован из исходной темы Recipe Book, где вместо рецептов используются задачи, а вместо ингредиентов и шагов — описание и статус.

## Краткая документация к проекту

### Структура проекта

```
task-manager/
├── public/
│   └── index.php           # Единая точка входа
├── src/
│   ├── handlers/
│   │   ├── task/
│   │   │   ├── create.php  # Обработчик создания задачи
│   │   │   ├── edit.php    # Обработчик редактирования задачи
│   │   │   ├── delete.php  # Обработчик удаления задачи
│   │   │   ├── list.php    # Обработчик списка задач
│   │   │   └── vulnerable.php # Обработчик уязвимого поиска
│   ├── migrations/
│   │   ├── 001_initial_schema.sql # Миграция для создания таблиц
│   │   └── run.php         # Скрипт выполнения миграций
│   ├── templates/
│   │   ├── layout.php      # Базовый шаблон
│   │   ├── task/
│   │   │   ├── index.php   # Шаблон списка задач
│   │   │   ├── create.php  # Шаблон создания задачи
│   │   │   ├── edit.php    # Шаблон редактирования задачи
│   │   │   ├── show.php    # Шаблон просмотра задачи
│   │   │   └── vulnerable.php # Шаблон уязвимого поиска
│   ├── db.php              # Подключение к базе данных
│   ├── helpers.php         # Вспомогательные функции
├── config/
│   └── db.php              # Конфигурация базы данных
├── .env                    # Настройки окружения
├── docker-compose.yml      # Конфигурация Docker
└── README.md               # Документация
```

### База данных

База данных `task_manager` содержит две таблицы:

- **categories**:
  ```sql
  CREATE TABLE categories (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(100) NOT NULL UNIQUE,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB;
  ```
- **tasks**:
  ```sql
  CREATE TABLE tasks (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      title VARCHAR(255) NOT NULL,
      description TEXT,
      category_id INT UNSIGNED NOT NULL,
      status VARCHAR(50) NOT NULL DEFAULT 'Pending',
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
  ) ENGINE=InnoDB;
  ```

### Основные функции

- **Создание задачи**: Добавление новой задачи с названием, описанием, категорией и статусом.
- **Редактирование задачи**: Обновление существующих задач.
- **Удаление задачи**: Удаление задачи по ID.
- **Список задач**: Отображение задач с пагинацией (5 задач на страницу).
- **Уязвимый поиск**: Демонстрация SQL-инъекции (для учебных целей).

## Примеры использования проекта

### 1. Список задач

Перейдите на `http://localhost:8080/?action=list` для просмотра списка задач.

**Результат**:

- Отображается таблица с задачами, разбитая на страницы (по 5 задач).
- Пример вывода:
  ```
  Название    Категория    Статус        Дата создания         Действия
  Задача 1    Работа       Pending       2025-04-23 17:19:47   Просмотр Редактировать Удалить
  Задача 2    Работа       In Progress   2025-04-23 17:19:47   Просмотр Редактировать Удалить
  ...
  ```
- Внизу страницы отображается пагинация: `« 1 2 3 »`.

**Код шаблона** (`templates/task/index.php`):

```php
<table class="table">
    <thead>
        <tr>
            <th>Название</th>
            <th>Категория</th>
            <th>Статус</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title'] ?? 'Без названия') ?></td>
                <td><?= htmlspecialchars($task['category_name'] ?? 'Без категории') ?></td>
                <td><?= htmlspecialchars($task['status'] ?? 'Не указан') ?></td>
                <td><?= htmlspecialchars($task['created_at'] ?? 'Неизвестно') ?></td>
                <td>
                    <a href="/?action=show&id=<?= (int) $task['id'] ?>">Просмотр</a>
                    <a href="/?action=edit&id=<?= (int) $task['id'] ?>">Редактировать</a>
                    <form action="/?action=delete" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= (int) $task['id'] ?>">
                        <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

### 2. Создание задачи

Перейдите на `http://localhost:8080/?action=create` для добавления новой задачи.

**Результат**:

- Отображается форма с полями: название, описание, категория, статус.
- После заполнения и отправки формы (например, "Задача 8", "Описание 8", категория "Работа", статус "Pending"), задача добавляется в список.

**Код формы** (`templates/task/create.php`):

```php
<form action="/?action=create" method="POST">
    <div class="mb-3">
        <label for="title" class="form-label">Название</label>
        <input type="text" name="title" id="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Описание</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Категория</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="0">Без категории</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Статус</label>
        <select name="status" id="status" class="form-control" required>
            <?php foreach ($validStatuses as $status): ?>
                <option value="<?= $status ?>"><?= htmlspecialchars($status) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Создать</button>
</form>
```

### 3. Демонстрация SQL-инъекции

Перейдите на `http://localhost:8080/?action=vulnerable` для тестирования уязвимого поиска.

**Результат**:

- Введите в поле поиска: `' OR '1'='1`.
- Отобразятся все задачи, так как запрос становится:
  ```sql
  SELECT t.*, c.name as category_name FROM tasks t LEFT JOIN categories c ON t.category_id = c.id WHERE t.title LIKE '%' OR '1'='1%'
  ```
- Это демонстрирует уязвимость к SQL-инъекции.

**Предотвращение**:
В безопасных запросах используются подготовленные выражения:

```php
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE title LIKE ?");
$stmt->execute(["%$search%"]);
```

## Ответы на контрольные вопросы

1. **Какие преимущества даёт использование единой точки входа в веб-приложении?**

   - Централизованное управление запросами, что упрощает маршрутизацию и обработку ошибок.
   - Повышение безопасности за счёт единого места для фильтрации и валидации запросов.
   - Упрощение добавления глобальных настроек (например, аутентификации).

2. **Какие преимущества даёт использование шаблонов?**

   - Разделение логики и представления, что улучшает читаемость и поддержку кода.
   - Повторное использование кода (например, единый `layout.php` для всех страниц).
   - Упрощение изменения дизайна без необходимости менять логику.

3. **Какие преимущества даёт хранение данных в базе по сравнению с хранением в файлах?**

   - Быстрый доступ к данным через индексы и SQL-запросы.
   - Поддержка транзакций и целостности данных (например, внешние ключи).
   - Масштабируемость: базы данных лучше справляются с большими объёмами данных.

4. **Что такое SQL-инъекция? Придумайте пример SQL-инъекции и объясните, как её предотвратить.**
   - SQL-инъекция — это атака, при которой злоумышленник вставляет вредоносный SQL-код в запрос.
   - Пример: Ввод `' OR '1'='1` в поле поиска приводит к выборке всех записей.
   - Предотвращение: Использование подготовленных выражений (`PDO::prepare`) и валидация входных данных.

## Список использованных источников

- Документация PHP: https://www.php.net/manual/en/
- Документация Bootstrap: https://getbootstrap.com/docs/5.3/
- Документация PDO: https://www.php.net/manual/en/book.pdo.php
- Руководство по SQL-инъекциям: https://owasp.org/www-community/attacks/SQL_Injection

## Дополнительные важные аспекты

- Проект использует Docker для упрощения разработки и деплоя.
- Реализована пагинация с использованием `LIMIT` и `OFFSET`.
- Добавлен уязвимый поиск для демонстрации SQL-инъекции (только в учебных целях).
- Bootstrap подключён локально (`public/assets/`), чтобы избежать зависимости от интернета.
