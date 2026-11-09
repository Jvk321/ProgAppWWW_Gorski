Przeglądarka: Google Chrome Wersja 156.0.8078.80 (Oficjalna wersja) (64-bitowa)

Motyw i nawigacja:
- zapamiętuje wybór, poprawne aria-pressed

Start trzy razy potem Stop i Start:
- jeden interwał, Start/Stop działa

Fragment nazwy ze spacjami i inną wielkością liter:
- ignoruje spacje i wielkość liter

Brak dopasowania i wyczyszczenie pola:
- komunikat, po wyczyszczeniu 3 karty

Cena 1999 gr oraz ilość 3:
- 59,97 zł

Ilość pusta 0 6 oraz 1,5:
- błędne wartości odrzucone

Dziesięć spacji oraz tekst <b>Test</b>:
- spacje odrzucone, HTML jako tekst

Klawiatura widoki i wyłączony JavaScript:
- Działa przy 375 i 1280 px, treść dostępna



Debugowanie w DevTools
----------------
Breakpoint
Ustawiłem breakpoint w funkcji aktualizacjaZapytania(). Sprawdziłem wartości zmiennych dla lampki i 2 sztuk.
- aktualnaIlosc: 2
- cenaWGroszach: 13000
- aktualnaCenaWZlotych: 260
- pln: 260,00 zł
Wynik: poprawny
----------------
Test zegara

Dodałem console.count() do funkcji time() i kliknąłem Start 3 razy. Sprawdziłem, czy działa tylko jeden interwał. Po Stop licznik powinien przestać rosnąć, a ponowny Start wznowić aktualizację.

Wynik: poprawny
----------------
Celowy błąd
W funkcji aktualizacjaZapytania() wywołałem nieistniejącą funkcję nieIstniejacaFunkcja()

Komunikat: ReferenceError: nieIstniejacaFunkcja is not defined

Numer linii: 169

Po sprawdzeniu usunąłem błędne wywołanie i przywróciłem poprawny kod.

Końcowa konsola: poprawny