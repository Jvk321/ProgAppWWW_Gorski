## Instrukcja uruchomienia

1. Umieść katalog lab5 w C:\xampp\htdocs\lab5 lub utwórz dowiązanie do katalogu projektu.
2. Uruchom XAMPP.
3. Włącz serwer Apache.
4. Otwórz przeglądarkę.
5. Przejdź do adresu: http://localhost/lab5/index.php

### Punkt odniesienia
Filtr katalogu: 
- Działa poprawnie, produkty są filtrowane według wybranej kategorii.

Zapis wyboru: 
- Formularz działa poprawnie, wybrany produkt i ilość zapisują się w sesji.

AJAX do status.php: 
- Żądanie działa poprawnie, serwer zwraca komunikat PHP działa.

### Testy

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

## Mapa widoków

- W pliku index.php znajduje się tablica $widoki.

Zarejestrowane identyfikatory:

- glowna – Home – html/glowna.html
- kontakt – Kontakt – html/kontakt.html
- produkt – Produkt – html/produkt.html
- filmy – Filmy – html/filmy.html

- Menu generowane jest za pomocą pętli foreach.
- Wybrany widok ma atrybut aria-current="page".
- Tytuł strony jest pobierany z mapy i zabezpieczany przez htmlspecialchars() z kodowaniem UTF-8.

## Pseudokod wyboru widoku
Utwórz mapę widoków.

Ustaw domyślny widok na "glowna".

Odczytaj parametr idp z $_GET.

JEŚLI idp nie istnieje lub jest pustym tekstem:
    Wybierz stronę główną.

W PRZECIWNYM RAZIE:
    JEŚLI idp jest tekstem i istnieje w mapie:
        Wybierz odpowiedni widok.
    W PRZECIWNYM RAZIE:
        Ustaw HTTP 404.
        Zapisz komunikat błędu.

JEŚLI nie wystąpił błąd:
    Zbuduj ścieżkę przez __DIR__ i wartość z mapy.

    JEŚLI plik nie istnieje lub nie jest czytelny:
        Ustaw HTTP 500.
        Zapisz komunikat błędu.

Wygeneruj wspólny szablon HTML.

Wygeneruj menu na podstawie mapy.

JEŚLI nie wystąpił błąd:
    Dołącz wybrany plik przez include.
W PRZECIWNYM RAZIE:
    Wyświetl komunikat błędu.
    Wyświetl link powrotny do strony głównej.


## Różnica między idp i kategoria

idp: parametr służący do wyboru podstrony w index.php.

Przykład:
index.php?idp=filmy

kategoria: 
parametr służący do filtrowania produktów w lab4.php.

Przykład:
lab4.php?kategoria=ksiazki

- Parametr idp wybiera widok strony, natomiast kategoria wybiera produkty do wyświetlenia w katalogu.

## Różnica między HTTP 404 i HTTP 500

HTTP 404: nie znaleziono podstrony.
- W projekcie występuje, gdy podany identyfikator nie istnieje w mapie lub ma nieprawidłowy typ.

HTTP 500: błąd po stronie serwera.
- W projekcie występuje, gdy widok istnieje w mapie, ale jego plik nie istnieje albo nie można go odczytać.
