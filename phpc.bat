@echo off

docker exec -it --user root --workdir /app php-corbomite-events bash -c "php %*"
