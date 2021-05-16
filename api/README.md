# Banking API Test

## Stack
* Docker-compose
* Nginx
* Php8
* Laravel/lumen
* Mysql
* PHPMyAdmin

## Step-by-step instructions
Build environment:
    
    mkdir -p docker/mysql/data && \
	mkdir -p docker/mysql/initdb && \
	docker-compose down && \
	docker-compose up -d --build && \
	docker system prune -f    

To run environment:

    docker-compose up -d

To stop environment:

    docker-compose stop

Config:

    rename .env.example to .env

Composer:

    docker-compose run --rm composer install

Migrations:

    docker-compose exec php php artisan migrate
    docker-compose exec php php artisan db:seed

Tests:

    docker-compose exec php vendor/bin/phpunit

Postman:
    
    import the POSTMAN.json file into the postman for easy use 

PS:

    - verify .env to change configurations.
    - DOCKER_USER_ID = 1000 and DOCKER_GROUP_ID = 1000, in .env, may have different values on your computer. check at your prompt with the command "id" 
    - If you have trouble accessing, check Header Authorization Bearer.
    - access_token is returned on route 172.22.0.2/authorization/token passing email and password.
    - Check UserSeeder to verify or change user.
