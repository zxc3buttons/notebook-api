# Notebook API
## Notebook API - это RESTful API для управления заметками в блокноте.

## Требования
PHP >= 8.1
Composer
MySQL >= 5.7

## Установка и запуск
1) Склонируйте репозиторий: `git clone https://github.com/zxc3buttons/notebook-api.git`
2) Перейдите в директорию проекта: `cd notebook-api`
3) Установите зависимости: `composer install`
4) Создайте файл .env из .env.example и настройте подключение к базе данных
5) Создайте базу данных с помощью команды: `php artisan migrate`
6) Заполните БД начальными тестовыми данными `php artisan db:seed`
7) Запустите приложение: `php artisan serve`

## Использование
API доступен по адресу http://localhost:8000/api/notebook

Доступные методы:

GET /api/notebook - получить список всех заметок
GET /api/notebook/{id} - получить заметку по ID
POST /api/notebook - создать новую заметку
POST /api/notebook/{id} - обновить существующую заметку по ID
DELETE /api/notebook/{id} - удалить заметку по ID

## Для пагинации списка заметок используйте параметры page и limit. Например: /api/notes?page=1&limit=10.

## Для более подробной информации об API обратитесь к Swagger UI: http://localhost:8000/api/documentation

## Тестирование
Для тестирования API методов использовался Postman

Была попытка развернуть приложение в docker, но ошибка connection refused, когда подключаешься из одного контейнера в другой мне не дала это сделать.
