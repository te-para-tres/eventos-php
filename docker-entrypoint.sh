#!/usr/bin/env sh
set -eu

cd /var/www/html

echo "Ejecutando migraciones de Yii..."
php yii migrate --interactive=0

exec "$@"
