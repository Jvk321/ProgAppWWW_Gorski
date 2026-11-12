## Testy animacji
1. Szybkie kliknięcia A
Kroki:
Zresetowano animację A, następnie szybko kliknięto przycisk 10 razy.

Wynik:
Przycisk wraca do wymiarów 160 × 90 px, bez zaległych animacji.

2. Kursor i fokus B
Kroki:
Najechano kursorem na przycisk, ustawiono na nim fokus, a następnie odsunięto kursor i usunięto fokus.

Wynik: 
Przycisk pozostaje powiększony przy zachowanym fokusie. Po utracie obu stanów wraca do 160 × 90 px.

3. Limit i reset C
Kroki: 
Kliknięto przycisk 5 razy, następnie kilka dodatkowych razy. Uruchomiono reset w trakcie animacji.

Wynik:
Po 5 krokach wymiary wynoszą 260 × 140 px. Dalsze kliknięcia są ignorowane. Reset przywraca 160 × 90 px i licznik 0.

4. Klawiatura i ograniczenie ruchu
Kroki: Przechodzono między przyciskami za pomocą Tab, używano Enter i Spacji. Włączono prefers-reduced-motion: reduce i odświeżono stronę.

Wynik:
Przyciski działają z klawiatury, fokus jest widoczny, a przy ograniczeniu ruchu animacje są natychmiastowe.

5. Wcześniejsze funkcje i Console
Kroki:
Sprawdzono zmianę motywu, działanie zegara i formularza. Otworzono Console w DevTools.

Wynik:
Wszystkie wcześniejsze funkcje działają, a Console nie zawiera błędów JavaScript.
