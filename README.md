## description
The project has been developed based on the Laravel framework, utilizing the latest version, and employing the MySQL database engine. The database structure has been designed to facilitate the storage of products along with their prices (each product can have multiple prices), and each product comes with its own description. Furthermore, endpoints have been set up to allow listing, sorting, and filtering of products, as well as presenting detailed information about a selected product. Authenticated users have the capability to manage products through adding, editing, and deleting them.

## Techonologies
- PHP 8.1.18
- Laravel 10.13.5

## Installation

1. docker-compose up -d
2. docker exec -ti MyLead-app bash
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. php artisan migrate
