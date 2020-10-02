### Requierments
PHP 7
Sqlite

### Install dependencies
composer install

### create database
./vendor/bin/doctrine orm:schema:create -f
./vendor/bin/doctrine orm:schema:update -f

### create a User
php commands/create_user.php username password roles

### Launch and test
php -S localhost:8000 -t public
