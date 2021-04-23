# Library - Проект для библиотеки СДУ
# Команда разработки - Automation Department SDU

## Требуется
- PHP >= 8.0

## Документация
* Документация генерируется на основе Open APIv3. 
* Swagger файл лежит по умолчанию в папке storage/api-docs/api-docs.json.
* Документация в json доступно по адресу /api/doc
* Документация в UI доступно по адресу /api/swaggerui, см конфиг l5-swagger.php
* После добавление нового маршрута в api.php, нужно запустить команду
```php
php artisan l5-swagger:generate
```

### Laravel ide helper for models

Для генерации помощника в модельках

```sh
php artisan ide-helper:models
```

### Линтеры

Для автоматический проверки и исправления качество кода используются следующие линтеры

#### [Psalm](https://psalm.dev/)

Конфигурационный файл - [psalm.xml](psalm.xml)
   
Команда для проверки

```sh
vendor/bin/psalm
```

Команда для исправления (фиксит не все ошибки). Подробнее [тут](https://psalm.dev/docs/manipulating_code/fixing/)

```sh
vendor/bin/psalter --issues=issue-name
```   
   
#### [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) 

Конфигурационный файл - [.php_cs](.php_cs)
   
Команда для проверки

```sh
vendor/bin/php-cs-fixer fix --dry-run
```

Команда для исправления

```sh
vendor/bin/php-cs-fixer fix
```
