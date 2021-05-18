# store-manager

### Install
        
    git clone git@github.com:eudotto/store-manager.git
    cd store-manager

Verifique se o id de usuário e id do grupo são as mesmas do sistema

    id

saída do comando id deve conter

    uid=1000(user) gid=1000(user) 

altere os valores do .env.example com o uid e gid
DOCKER_USER_ID=1000
DOCKER_GROUP_ID=1000

altere o .env.example para .env. Adicione uma cópia do .env dentro do diretório api

Build:

    mkdir -p docker/mysql/data && \
	mkdir -p docker/mysql/initdb && \
	docker-compose down && \
	docker-compose up -d --build && \
	docker system prune -f    

para parar o ambiente:

    docker-compose stop

para retornar o ambiente:

    docker-compose up -d

Composer:

    docker-compose run --rm composer install

Migrations:

    docker-compose exec php php artisan migrate
    docker-compose exec php php artisan db:seed

Testes:

    docker-compose exec php vendor/bin/phpunit

Postman:

    importe o arquivo POSTMAN.json para PostMan para facilitar o teste da api  


