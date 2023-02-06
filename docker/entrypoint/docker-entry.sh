#!/bin/sh
set -e

php docker/composer.phar install --no-interaction --prefer-dist --optimize-autoloader

php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:schema:update --force

php bin/console cache:clear
php bin/console cache:warmup

chmod -R 777 /var/www/var
chmod -R 777 /var/www/public
chmod -R 777 /var/www/config/

## server config
php-fpm -D &
nginx -g "daemon off;"