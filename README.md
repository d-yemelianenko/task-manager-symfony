# Task Manager w Symfony

Nowoczesna wersja aplikacji CRUD do zarządzania zadaniami, tworzona na podstawie wcześniejszego projektu w czystym PHP.

## Funkcjonalności

- Pełny CRUD zadań
- System uwierzytelniania użytkowników
- Dashboard ze statystykami zadań
- Responsywny design (karty na mobile, tabela na desktop)
- System priorytetów i statusów zadań

## Screenshots

### Widok listy zadań na desktopie
<img width="1591" height="497" alt="lista_desctop" src="https://github.com/user-attachments/assets/961b2aac-af17-4367-8d04-699b73408935" />

### Dashboard ze statystykami
<img width="1586" height="457" alt="dashboard" src="https://github.com/user-attachments/assets/11d4795e-a0c0-4382-89c2-54fee628b4a0" />

### Widok listy zadań na mobile
<img width="401" height="777" alt="lista_mobile" src="https://github.com/user-attachments/assets/00e6127d-0336-40eb-956d-5f62f643322a" />

### Ekran logowania na mobile
<img width="365" height="709" alt="login_mobile" src="https://github.com/user-attachments/assets/f3540719-1946-4d95-8440-141b0d927070" />


## Wymagania

PHP 8.1 lub nowszy<br>
Composer<br>
MySQL 5.7 lub nowszy<br>
Symfony CLI (opcjonalnie)<br>

## Instalacja

1. Sklonuj repozytorium
git clone [adres-repozytorium]
cd task-manager

2. Zainstaluj zależności PHP
composer install

3. Skonfiguruj bazę danych
Edytuj plik .env i ustaw DATABASE_URL:
DATABASE_URL="mysql://username:password@127.0.0.1:3306/task_manager"

4. Utwórz bazę danych i wykonaj migracje
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

5. Załaduj dane testowe
php bin/console doctrine:fixtures:load

6. Uruchom serwer deweloperski
symfony serve

7. Otwórz aplikację w przeglądarce
http://localhost:....

## Użycie

Zarejestruj nowe konto lub użyj danych testowych<br>
Dodawaj nowe zadania z tytułem, opisem, priorytetem i terminem<br>
Przeglądaj statystyki na dashboardzie<br>
Edytuj i usuwaj zadania według potrzeb<br>
Aplikacja automatycznie dostosowuje wygląd do urządzenia<br>

## Struktura projektu

src/Controller/ - Kontrolery aplikacji<br>
src/Entity/ - Encje Doctrine<br>
src/Repository/ - Repozytoria danych<br>
templates/ - Szablony Twig<br>
migrations/ - Migracje bazy danych<br>

## Technologie

- Symfony 6.x
- PHP 8.x
- MySQL
- Doctrine ORM
- Bootstrap 5
- Twig
