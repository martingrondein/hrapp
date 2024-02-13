# HR App

## Features

- HR management system
  - featuring with dark/light themes
- Staff management
  - Import/Export staff from/to .csv/xlsx
  - Personal / company information
  - Documents
  - Leave management
- Department management

## Technologies

- Docker
  - PHP
  - Node
  - Nginx
  - MariaDB
- Laravel
  - Migrations
  - Queues
  - Models
  - Seeders
- Filament
  - Livewire

## Bash direct access

```bash
docker-compose exec -it php sh
```

## Artisan

```bash
docker-compose exec -it php php artisan
```

## Composer

```bash
docker-compose exec -it php composer install
docker-compose exec -it php composer update
```

## Node

```bash
docker-compose exec -it php npm install
docker-compose exec -it php npm run dev
docker-compose exec -it php npm run build
```

## Add first admin user

```bash
docker-compose exec -it php php artisan make:filament-user
```

## Seed Database

```bash
docker-compose exec -it php php artisan db:seed
```
