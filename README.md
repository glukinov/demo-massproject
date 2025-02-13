# Тестовое задание

## Установка и настройка
```bash
git clone git@github.com:glukinov/demo-massproject.git
docker compose up -d
php yii migrate
php init
php yii user/create
```

## Параметры базы данных
```php
[
    'dsn' => 'mysql:host=mysql;dbname=demo',
    'username' => 'demo',
    'password' => 'demo',
];
```
