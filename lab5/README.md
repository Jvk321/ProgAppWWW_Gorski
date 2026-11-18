## Punkt odniesienia
Filtr katalogu: 
- Działa poprawnie, produkty są filtrowane według wybranej kategorii.

Zapis wyboru: 
- Formularz działa poprawnie, wybrany produkt i ilość zapisują się w sesji.

AJAX do status.php: 
- Żądanie działa poprawnie, serwer zwraca komunikat PHP działa.

## Testy

Przeglądarka: Google Chrome
Środowisko: XAMPP, Apache, PHP
Adres: http://localhost/lab5/

### Adres domyślny i menu

Kroki:
1. Otwórz index.php oraz index.php?idp=.
2. Przejdź przez wszystkie linki menu.
3. Sprawdź tytuły i wspólny wygląd stron.

wynik:
- oba adresy pokazują stronę główną (HTTP 200).
- menu otwiera odpowiednie podstrony ze wspólnym szablonem.

### Nieznany lub tablicowy klucz

Kroki:
1. Otwórz index.php?idp=nieznana.
2. Otwórz index.php?idp[]=filmy.
3. Sprawdź kody w Network.

wynik:
- oba adresy zwracają HTTP 404.
- wyświetla się komunikat i link powrotny.
- brak ostrzeżeń PHP.

### Próba podania ścieżki

Kroki:
1. Otwórz index.php?idp=..%2Fstatus.php.
2. Sprawdź odpowiedź w Network.

wynik:
- HTTP 404. Plik status.php nie zostaje dołączony.

### Brak pliku widoku

Kroki:
1. Zmień tymczasowo nazwę html/filmy.html.
2. Otwórz index.php?idp=filmy.
3. Sprawdź kod odpowiedzi.
4. Przywróć oryginalną nazwę pliku.

wynik:
- HTTP 500 i komunikat błędu bez ścieżki systemowej.

### Strona główna i AJAX

Kroki:
1. Otwórz stronę główną.
2. Sprawdź grafiki, style i animacje.
3. Kliknij „Sprawdź serwer”.
4. Sprawdź żądanie status.php w Network.

wynik:
- Elementy strony działają poprawnie.
- żądanie AJAX zwraca HTTP 200 i tekst PHP działa.

### Katalog i sesja po migracji

Kroki:
1. Otwórz Katalog PHP z menu.
2. Przefiltruj produkty.
3. Zapisz poprawny wybór produktu.
4. Sprawdź POST i przekierowanie w Network.
5. Przejdź na stronę główną i do Filmów.
6. Wróć do katalogu.

wynik:
- filtrowanie działa poprawnie.
- POST zwraca HTTP 303, a następnie GET HTTP 200.
- ostatni wybór pozostaje zapisany w sesji.

### Filmy i układ mobilny

Kroki:
1. Otwórz index.php?idp=filmy.
2. Uruchom wszystkie trzy filmy.
3. Sprawdź odnośniki do YouTube.
4. Ustaw szerokość ekranu na 360 px.
5. Sprawdź nawigację klawiszem Tab.

wynik:
- trzy filmy można odtworzyć.
- odnośniki działają i są dostępne klawiszem Tab.
Odtwarzacze mieszczą się w widoku 360 px.
Brak automatycznego odtwarzania.

