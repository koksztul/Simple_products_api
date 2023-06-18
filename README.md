## PHP and laravel version
- PHP 8.1.18
- Laravel 10.13.5

## build and run api

1. docker-compose up -d
2. docker exec -ti MyLead-app bash
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. php artisan migrate
