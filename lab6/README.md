# Chwila v1.5/Lab 6

## Uruchomienie w XAMPP

1. Umieść lab6 w C:\xampp\htdocs\lab6. Włącz Apache i MySQL w XAMPP. PHP potrzebuje rozszerzenia pdo_mysql.
2. W phpMyAdmin http://localhost/phpmyadmin/ zaloguj się jako administrator. W zakładce import wczytaj schema.sql i seed.sql.
3. W zakładce SQL utwórz konto do odczytu. Wpisz własne hasło zamiast WPISZ_WLASNE_HASLO.
   ```sql
   CREATE USER 'chwila_cms'@'127.0.0.1' IDENTIFIED BY 'WPISZ_WLASNE_HASLO';
   GRANT SELECT ON moja_strona.page_list TO 'chwila_cms'@'127.0.0.1';
   ```
4. Skopiuj cfg.example.php jako cfg.php. Wpisz użytkownika chwila_cms i hasło. Git pomija cfg.php.
5. Otwórz stronę główną. Przy błędzie 500 sprawdź log PHP wskazany przez error_log w C:\xampp\php\php.ini.

## Jak działa strona

Cztery podstrony z Lab 5 i szkic O sklepie są w tabeli page_list. id to stały numer rekordu, a alias to nazwa używana w adresie. Funkcja PokazPodstrone() przekazuje alias jako parametr zapytania PDO i pobiera jeden opublikowany rekord. Menu powstaje z osobnego zapytania, w kolejności id. Tytuły są wypisywane przez htmlspecialchars(), a bieżący link ma aria-current="page".

Katalog produktów http://localhost/lab6/lab4.php nadal zapisuje wybór w sesji. Panel CMS http://localhost/lab6/admin/admin.php ma nagłówek i link powrotny.

## Pseudokod
- Jeśli idp jest pusty lub go brakuje, użyj aliasu glowna.
- Połącz się z bazą i pobierz opublikowane strony do menu.
- Jeśli alias jest tekstem złożonym z 1–20 małych liter a-z, cyfr lub łączników, pobierz opublikowaną stronę przez parametr :alias.
- Jeśli brak pasującej strony, ustaw 404.
- Jeśli połączenie lub zapytanie zgłosi błąd, zapisz go w logu i ustaw 500.
- Pokaż wspólny szablon z treścią strony albo z komunikatem i linkiem powrotnym.

## Testy

### Odczyt i zmiana treści
- Otwórz index.php, index.php?idp= i index.php?idp=glowna. Zmień treść glowna w bazie, odśwież stronę i przywróć oryginał.

- Oczekiwany wynik: wszystkie trzy adresy dają 200. Nowa treść pojawia się po odświeżeniu.
- Rzeczywisty wynik: wszystkie adresy dały 200. Po zmianie w bazie pojawił się testowy nagłówek.

### Nowa strona i menu
- Dodaj opublikowany rekord nowa-strona i otwórz index.php?idp=nowa-strona. Po próbie usuń rekord.

- Oczekiwany wynik: strona daje 200, a jej link pojawia się w menu i jest oznaczony jako aktywny.
- Rzeczywisty wynik: strona dała 200. Aktywny link pojawił się za Filmami.

### Szkic i publikacja

1. Otwórz szkic O sklepie http://localhost/lab6/index.php?idp=o-sklepie
2. Zmień status na 1, odśwież stronę i sprawdź menu.
3. Spróbuj dodać drugi rekord z tym samym aliasem. Po próbie przywróć status 0.

- Oczekiwany wynik: szkic jest ukryty i daje 404. Po publikacji zwraca 200 i pojawia się w menu. Baza odrzuca duplikat.
- Rzeczywisty wynik: szkic dał 404. Po publikacji strona dała 200 i pojawił się link. Baza odrzuciła duplikat.

### Błędne adresy

Otwórz index.php kolejno z tymi parametrami.

?idp=nieznana
?idp%5B%5D=filmy
?idp=..%2Fcfg.php
?idp=%27%20OR%201%3D1--

- Oczekiwany wynik: każdy adres daje 404 i link powrotny.
- Rzeczywisty wynik: wszystkie adresy dały 404 i link powrotny. Nie pojawiły się ostrzeżenia PHP.

### Awaria bazy

Wpisz nieużywany port w cfg.php, odśwież stronę, sprawdź log PHP i przywróć poprzedni port.

- Oczekiwany wynik: strona daje 500 z ogólnym komunikatem, a szczegóły trafiają do logu. Po przywróceniu portu strona daje 200.
- Rzeczywisty wynik: strona dała 500 z ogólnym komunikatem. W logu pojawił się błąd PDO. Po przywróceniu portu strona dała 200.

### Funkcje po migracji

1. Na stronie głównej sprawdź obrazy i animacje. Kliknij Sprawdź serwer.
2. Przefiltruj katalog, zapisz wybór wazonu, przejdź na inną podstronę i wróć do katalogu.

- Oczekiwany wynik: obrazy i animacje działają, AJAX zwraca PHP działa, a filtr pokazuje książki. Zapis daje POST 303 i GET 200, a wybór zostaje w sesji.
- Rzeczywisty wynik: obrazy i animacje działały. AJAX zwrócił 200 i PHP działa. Filtr zadziałał, zapis dał 303 i 200, a wybór został w sesji.

Otwórz Filmy przy szerokości 360 px i spróbuj włączyć każdy film.

- Oczekiwany wynik: trzy odtwarzacze mieszczą się w oknie i każdy film można odtworzyć.
- Rzeczywisty wynik: trzy odtwarzacze mieściły się w oknie.

### Odtworzenie bazy

Powtórz import w pustej bazie testowej. Jej nazwę ustaw w obu plikach SQL, poleceniu GRANT i cfg.php.

- Oczekiwany wynik: strony dają 200, polskie znaki wyświetlają się poprawnie, a konto może odczytać tabelę stron.
- Rzeczywisty wynik: na osobnej bazie strona główna i Filmy dały 200. Polskie znaki wyświetlały się poprawnie, a konto miało prawo SELECT do tabeli stron.
