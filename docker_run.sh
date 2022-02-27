#!/bin/bash
set -e

cd /var/www; php artisan config:cache
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear
env >> /var/www/.env
php-fpm7.4 -D
nginx -g "daemon off;"
