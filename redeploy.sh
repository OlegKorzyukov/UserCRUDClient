#!/bin/sh
export RUN_ENV=dev

docker-compose up -d --force-recreate --build
docker-compose exec php /bin/bash -c "cd /var/www/html && composer install --no-interaction"
