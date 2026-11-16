
## Testy działania

Środowisko: XAMPP, Apache, PHP  
Adres: http://localhost/lab4/lab4.php  
Przeglądarka: Chrome

### 1. Filtr GET

Kroki:
1. Otwórz lab4.php?kategoria=ksiazki.
2. Otwórz lab4.php?kategoria=inna.
3. Otwórz lab4.php?kategoria[]=ksiazki.

Oczekiwany wynik:
- Dla ksiazki wyświetlają się tylko książki. Nieprawidłowa kategoria lub tablica powoduje wyświetlenie wszystkich produktów i komunikatu błędu.

Rzeczywisty wynik:
- Po wybraniu kategorii ksiazki wyświetla się tylko książka. Dla nieznanej kategorii i kategoria[]=ksiazki wyświetlają się wszystkie produkty oraz komunikat „Nieprawidłowa kategoria!”.

Metoda: GET  
Kod odpowiedzi: 200

### 2. Poprawny POST i odświeżenie

Kroki:
1. Wybierz dostępny produkt i poprawną ilość.
2. Kliknij „Zapisz wybór”.
3. Sprawdź żądania w Network.
4. Odśwież stronę i zmień filtr kategorii.

Oczekiwany wynik:
- POST zwraca HTTP 303, a następnie GET zwraca HTTP 200. Ostatni wybór pozostaje widoczny po odświeżeniu i zmianie filtra.

Rzeczywisty wynik: 
- Po zapisaniu produktu wyświetla się jego nazwa i wybrana ilość. Po odświeżeniu strony i zmianie filtra wybór pozostaje zapisany.

POST: 303 See Other
GET: 200 OK

### 3. Błędne wartości POST

Kroki:
1. Zapisz najpierw poprawny wybór.
2. W DevTools: Elements (Inspektor) zmodyfikuj wartości formularza.
3. Przetestuj kolejno:
   - ilość 0
   - ilość 6
   - ilość 2.5
   - ilość 2abc
   - brak pola usuń atrybut name
   - tablicę zmień name="ilosc" na name="ilosc[]"
   - nieistniejący identyfikator produktu
4. Sprawdź odpowiedzi w Network i poprzedni wybór.

Oczekiwany wynik:  
- Każda niepoprawna wartość powoduje HTTP 400 i wyświetlenie komunikatu. Wcześniejszy wybór w sesji pozostaje bez zmian.

Rzeczywiste wyniki:
- Wartości 0, 6, 2.5, 2abc, brak pola, tablica oraz nieistniejący produkt zostały odrzucone.  Wyświetla się komunikat błędu, a poprzedni wybór pozostaje zapisany.

Ilość: 0, kod: 400 Bad Request
Ilość: 6, kod: 400 Bad Request  
Ilość: 2.5, kod: 400 Bad Request  
Ilość: 2abc, kod: 400 Bad Request  
Brak pola, kod: 400 Bad Request  
Tablica, kod: 400 Bad Request 
Nieznany produkt, kod: 400 Bad Request 

Zachowanie poprzedniego wyboru:  
- każde błędne żądanie POST zwraca HTTP 400, pojawia się komunikat błędu, a poprzedni wybór w sesji pozostaje bez zmian.

### 4. Stan magazynowy

Kroki:
1. Wybierz produkt Wazon ceramiczny stan 1.
2. W Inspektorze zmień ilość na 2.
3. Wyślij formularz i sprawdź Network.

Oczekiwany wynik:
HTTP 400 i komunikat błędu. Serwer odrzuca wybór, ponieważ ilość przekracza stan magazynowy.

Rzeczywisty wynik:  
wynik to POST 400, ponieważ wybieram 2 sztuki produktu, którego jest tylko 1.

Metoda: POST  
Kod odpowiedzi: 400

### 5. Odrębna sesja i tekst HTML

Kroki:
1. Otwórz lab4.php w nowym oknie prywatnym.
2. Sprawdź, czy wyświetla się ostatni wybór.
3. Tymczasowo zmień nazwę produktu w includes/produkty.php na Test
4. Odśwież katalog.
5. Przywróć poprzednią nazwę produktu.

Oczekiwany wynik:
W nowej sesji wyświetla się Nie wybrano jeszcze produktu. Nazwa Test pojawia się jako zwykły tekst, a nie pogrubiony napis.

Rzeczywisty wynik:
Nazwa Test pojawia się jako zwykły tekst

Metoda: GET  
Kod odpowiedzi: 200
### 6. Strona po zmianie ścieżek

Kroki:
1. Otwórz http://localhost/lab4/
2. Sprawdź stronę główną i wszystkie podstrony.
3. Sprawdź style, obrazy i linki.
4. Sprawdź animacje z Lab 3.
5. Sprawdź żądanie AJAX do status.php.

wynik:
Strony i zasoby działają poprawnie. Animacje działają zgodnie z Lab 3, a żądanie do status.php zwraca poprawną odpowiedź.

Metody: GET
Kod: 200
