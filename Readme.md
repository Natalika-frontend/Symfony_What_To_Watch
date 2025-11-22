* Студент: [Наталья Романова](https://up.htmlacademy.ru/yii-individual/1/user/1515049).
* Наставник: `Александр Смиркин`.

# What To Watch — Symfony backend (Прототип)

Простой backend-сервис для каталога фильмов: регистрация пользователей, роли, фильмы, жанры, комментарии, избранное.  
Реализовано на Symfony (PHP), Doctrine ORM, Messenger (очереди), Validator, Forms и тестах.

## Требования
- PHP 8.1+
- Composer
- MySQL (или PostgreSQL)
- (опционально) Symfony CLI (`symfony`)

## Быстрый старт (локально)

1. Клонировать репозиторий:
   ```
   git clone <repo-url> what-to-watch
   cd what-to-watch
2. Установить зависимости:

    ```
    composer install

3. Создать .env.local и настроить DATABASE_URL:
    ```
    DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/symfony_movies?serverVersion=8&charset=utf8mb4"
    MESSENGER_TRANSPORT_DSN=doctrine://default

4. Создать базу данных:
    ```
    php bin/console doctrine:database:create

5. Выполнить миграции:

    ```
    php bin/console doctrine:migrations:migrate
6. Загрузить тестовые данные:

    ```
    php bin/console doctrine:fixtures:load

7. Запустить сервер:

    ```
    symfony server:start

# или
php -S 127.0.0.1:8000 -t public
(Опционально) Запустить worker для Messenger:

    ```
    php bin/console messenger:consume async -vv

8. Запуск тестов

    ```
    vendor/bin/phpunit

Основные эндпоинты

GET /api/films — список фильмов
GET /api/films/{id} — фильм по id
POST /api/register — регистрация (JSON or form)
POST /api/login — логин


Архитектура
src/Entity — сущности Doctrine
src/Repository — репозитории
src/Services — бизнес-логика
src/Controller — HTTP-контроллеры (web и api)
src/Dto — DTO для передачи данных
src/Message & src/MessageHandler — сообщения и обработчики (Messenger)
tests/ — юнит и функциональные тесты

