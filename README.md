# Тестовое задание
Веб-приложение позволяет пользователю с административными правами добавлять, просматривать и удалять контакты. Написано на чистом PHP, без использования фреймворков.

## Содержание
- [Технологии](#технологии)
- [Описание](#описание)
- [Использование](#использование)
    - [Требования](#требования) 
    - [Установка](#установка)

## Технологии
- PHP 8.1
- MySQL 8.0
- HTML5
- CSS3
- jQuery 3.7.1

## Описание
Данное приложение позволяет создавать и удалять пользователей, а также просматривать их полный список. 

Хранение данных реализовано с помощью Базы Данных (БД) MySQL, работа с которой осуществляется с использованием расширения PDO. Данные для подключения настраиваются в файле database.php (в директории config).

Приложение написано с использованием ООП и имитирует структуру проектов, написанных с использованием фреймворков. 
- В директории config хранятся файлы с конфигурациями в виде массивов.
- В директории public располагаются файлы публичной части. В этой папке находится файл index.php, который является точкой входа в приложение.
- В директории src находятся основные классы приложения (контроллеры, модели, репозитории, классы маршуртизации ...).
- В templates - шаблоны страниц и их компоненты.

Кроме того, используются flash-сообщения для уведомления о возникновении каких-либо ошибок или об успешном создании пользователя.

Предусмотрена авторизация существующих пользователей с помощью логина (имени) и пароля. При этом возмоность удаления пользователей и создания новых есть только у администратора, чьи входные данные задаются в файле конфигураций admin.php. 

Удаление пользователей осуществляется с помощью AJAX-запросов без перезагрузки страницы браузера.

## Использование
### Требования
Для установки и запуска проекта необходим PHP v8.1+ и MySQL v8.0+.

### Установка
1. Для работы с БД, при необходимости, измените в конфигурационных файлах данные подключения к базе. После этого, находясь в папке с проектом, запустите скрипт (start_database.php) для создания базы данных и требуемых для работы таблиц. Для этого необходимо выполнить следующую команду:
```sh
php start_database.php
```

2. В качестве сервера будет достаточно использовать встроенный веб-сервер PHP, который можно запустить с помощью следующей команды: 
```sh
cd public
php -S localhost:8000
```
Вместо `php` может потребоваться прописать путь, по которому у Вас находится PHP (вида `C:\\php81\php.exe`).

3. Откройте в браузере страницу `localhost:8000`.

Можно начинать пользоваться приложением.