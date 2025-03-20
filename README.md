# URL Monitor

System monitorowania stron internetowych stworzony w Laravel. Aplikacja umożliwia śledzenie dostępności wielu stron, mierzy czas odpowiedzi i zapisuje historię sprawdzeń. Wykorzystuje PHP 8.2, MySQL i Bootstrap. Pozwala na automatyczne sprawdzanie w określonych interwałach oraz kategoryzację monitorowanych stron.

## Funkcje
- Monitorowanie wielu stron jednocześnie
- Automatyczne sprawdzanie dostępności
- Mierzenie czasu odpowiedzi
- Historia sprawdzeń
- Kategoryzacja stron
- Przyjazny interfejs użytkownika

## Technologie
- PHP 8.2
- Laravel
- MySQL
- Bootstrap
- jQuery
- Font Awesome

## Instalacja
1. Sklonuj repozytorium
2. Uruchom `composer install`
3. Skopiuj `.env.example` do `.env`
4. Skonfiguruj bazę danych w `.env`
5. Uruchom `php artisan key:generate`
6. Uruchom `php artisan migrate`
7. Uruchom `php artisan serve`
