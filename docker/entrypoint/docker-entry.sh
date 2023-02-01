#!/bin/sh
set -e

php docker/composer.phar install --no-interaction --prefer-dist --optimize-autoloader

## Symfony configuration

php bin/console doctrine:database:create --if-not-exists --quiet --no-interaction
php bin/console doctrine:migrations:migrate --verbose --no-interaction --allow-no-migration
php bin/console bolt:add-user --admin

php bin/console cache:clear
php bin/console cache:warmup

chmod -R 777 /var/www/var
chmod -R 777 /var/www/public

## server config
php-fpm -D &
nginx -g "daemon off;"