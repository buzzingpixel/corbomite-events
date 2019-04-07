@echo off

docker-compose -f docker-compose.yml -p corbomite-events up -d
docker exec -it --user root --workdir /app php-corbomite-events bash -c "cd /app && composer install"
