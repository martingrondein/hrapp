# HRApp

A free self-hosted HR management system that runs on open-source software allowing you to manage your company's departments, staff and their direct reports. Built with Laravel with ❤️.

## Features

- HR management system
  - featuring with dark/light themes
- Staff management
  - Personal / company information
  - Import/Export staff from/to .csv/xlsx (Beta)
  - Documents * (Coming soon)
  - Leave management * (Coming soon)
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

## First Time Setup

Setup commands:

```bash
cp .env.sample .env
cp src/.env.example src/.env
docker-compose up -d
docker-compose exec -it php composer install
docker-compose exec -it php npm install
docker-compose exec -it php npm run build
docker-compose exec -it php php artisan migrate
docker-compose exec -it php php artisan make:filament-user
```

Open your browser to [http://localhost/admin](http://localhost/admin)

## Developer commands

### Bash direct access

```bash
docker-compose exec -it php sh
```

### Artisan

```bash
docker-compose exec -it php php artisan
```

### Composer

```bash
docker-compose exec -it php composer install
docker-compose exec -it php composer update
```

### Node

```bash
docker-compose exec -it php npm install
docker-compose exec -it php npm run dev
docker-compose exec -it php npm run build
```

### Add first admin user

```bash
docker-compose exec -it php php artisan make:filament-user
```

### Seed Database with dummy information

```bash
docker-compose exec -it php php artisan db:seed
```
