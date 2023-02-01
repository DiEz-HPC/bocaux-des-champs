#!/bin/sh
set -e

php docker/composer.phar install --no-interaction --prefer-dist --optimize-autoloader


php bin/console cache:clear
php bin/console cache:warmup

chmod -R 777 /var/www/var
chmod -R 777 /var/www/public

## server config
php-fpm -D &
nginx -g "daemon off;"