#!/bin/sh
set -e

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

cd /var/www/html

composer install --optimize-autoloader --no-interaction --no-progress

npm install
# npm run dev &
npm run build

exec "$@"
