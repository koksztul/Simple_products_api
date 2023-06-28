## opis
Projekt został przygotowany na podstawie frameworka Laravel, najnowszej wersji, oraz wykorzystuje silnik bazy danych MySQL. Struktura bazodanowa została stworzona, umożliwiając przechowywanie produktów wraz z cenami (jeden produkt może być dostępny w wielu cenach), a każdy produkt posiada swój opis. Dodatkowo, endpointy zostały przygotowane, umożliwiając wylistowanie, sortowanie, filtrowanie produktów oraz prezentację informacji szczegółowych o wybranym produkcie. Użytkownicy zalogowani mają możliwość zarządzania produktami poprzez dodawanie, edycję i usuwanie produktów.

## Technologie
- PHP 8.1.18
- Laravel 10.13.5

## instalacja

1. docker-compose up -d
2. docker exec -ti MyLead-app bash
3. composer install
4. cp .env.example .env
5. php artisan key:generate
6. php artisan migrate
