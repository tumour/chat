# Chat

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

```
Docker
Dokcer Compose
```

### Installing

Чтобы запустить проект на локальной машине, необзодимо запустить 

```
docker-compose build
docker-compose up -d
docker-compose exec php-fpm bash
cd /var/www
cp .env.example .env
composer install
php artisan key:generate
php artisan migration
yarn
yarn dev
```

## Running the tests

```
docker-compose exec php-fpm bash
cd /var/www/
php artisan test
```
