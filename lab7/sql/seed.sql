USE moja_strona;

INSERT INTO page_list (alias, page_title, page_content, status) VALUES
('glowna', 'Home', '<h1>Produkty</h1>

<div id="search-catalog">
    <label for="search">Wyszukaj produkt:</label>
    <input type="search" id="search" size="30">
    <p id="wynik" aria-live="polite"></p>
</div>

<section class="card-container">
    <a href="index.php?idp=produkt" class="card">
        <article>
            <h2 class="h-two">Lampka nocna led</h2>
            <img src="./img/produkt_1/produkt1.png" alt="lampka led">
            <p class="opis">Idealna do sypialni i przytulnych wnętrz</p>
            <p class="cena">130 zł</p>
        </article>
    </a>
    <a href="#" class="card">
        <article>
            <h2 class="h-two">Wazon ceramiczny</h2>
            <img src="./img/p2.png" alt="wazon ceramiczny">
            <p class="opis">idealny do nowoczesnych wnętrz</p>
            <p class="cena">105 zł</p>
        </article>
    </a>
    <a href="#" class="card">
        <article>
            <h2 class="h-two">Świeca zapachowa</h2>
            <img src="./img/p3.png" alt="świeca zapachowa">
            <p class="opis">w szkle, która tworzy relaksującą atmosferę</p>
            <p class="cena">59 zł</p>
        </article>
    </a>
</section>

<section id="d-container">
    <div id="demo-section">
        <button id="btn-animation-a" class="animation" type="button" aria-pressed="false">click</button>
        <button id="btn-animation-b" class="animation" type="button">click</button>
        <div class="demo-container">
            <button id="btn-animation-c" class="animation" type="button">click</button>
            <p id="c-status" role="status">Licznik: 0</p>
        </div>
    </div>
    <button id="stop-ani" type="button" class="animation">Resetuj A i C</button>
</section>

<section id="sekcja-sprawdz-server">
    <button type="button" id="check-server">Sprawdź serwer</button>
    <p id="server-status" role="status"></p>
</section>', 1),
('kontakt', 'Kontakt', '<h1>Kontakt</h1>

<form id="potwierdzenie" action="index.php" method="get">
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="produkty">Produkt</label>
        <select name="produkt" id="produkty" required>
            <option value="">-- Wybierz produkt --</option>
            <option value="p1">Lampka nocna led</option>
            <option value="p2">Wazon ceramiczny</option>
            <option value="p3">Świeca zapachowa</option>
        </select>
        <div id="komunikatOne"></div>
    </div>
    <div>
        <label for="ilosc">Liczba sztuk</label>
        <input type="number" id="ilosc" name="ilosc" required min="1" max="5" step="1">
        <div id="komunikatTwo"></div>
    </div>
    <div>
        <label for="wiadomosc">Wiadomość:</label>
        <textarea name="wiadomosc" id="wiadomosc" required minlength="10" maxlength="500"></textarea>
        <div id="komunikatThree"></div>
    </div>
    <div id="cenaCalkowita"></div>
    <button type="submit" class="button-style-one">Sprawdź zapytanie</button>
</form>
<p class="text-under-form">Podgląd lokalny. Formularz nie wysyła wiadomości</p>
<section id="podsumowanie" hidden>
    <h2>Podsumowanie zapytania</h2>
    <hr>
    <div class="podsumowanie-wiersz">
        <h3>Produkt</h3>
        <div id="pod-produkt"></div>
    </div>
    <div class="podsumowanie-wiersz">
        <h3>Liczba sztuk</h3>
        <div id="pod-ilosc"></div>
    </div>
    <div class="podsumowanie-wiersz">
        <h3>Wartość zapytania</h3>
        <div id="pod-cena"></div>
    </div>
    <h3>Treść wiadomości</h3>
    <div id="pod-wiadomosc"></div>
</section>
        ', 1),
('produkt', 'Produkt', '<section class="product">
    <img class="product-img" src="./img/produkt_1/produkt1.png" alt="lampka led">
    <div>
        <h1 class="product-header">Lampka nocna led</h1>
        <p class="cena-product">130 zł</p>
        <a href="index.php?idp=kontakt" id="product-button" class="button-style-one">Zapytaj o produkt</a>
        <hr />
        <h3 class="product-h-three">Opis produktu</h3>
        <p><strong>Nowoczesna lampka LED</strong> z drewnianą podstawą, która wprowadza ciepłe, przyjemne światło i tworzy przytulną atmosferę w sypialni lub salonie. Minimalistyczny design doskonale pasuje do każdego wnętrza.</p>
        <h3>Zalety produktu</h3>
        <ul>
            <li>Przyjemne światło</li>
            <li>Minimalistyczny design</li>
            <li>Prosta obsługa</li>
        </ul>
    </div>
    <table>
        <caption>Specyfikacja techniczna lampki nocnej LED</caption>
        <thead>
            <tr>
                <th scope="col">Cecha produktu</th>
                <th scope="col">Opis</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rodzaj oświetlenia</td>
                <td>LED</td>
            </tr>
            <tr>
                <td>Sposób obsługi</td>
                <td>Przycisk na podstawie</td>
            </tr>
            <tr>
                <td>Materiał wykonania</td>
                <td>Tworzywo sztuczne, podstawa imitująca drewno</td>
            </tr>
        </tbody>
    </table>
</section>', 1),
('filmy', 'Filmy', '<section class="filmy">
    <h1>Filmy i inspiracje</h1>
    <article class="film">
        <h2>Oświetlenie we wnętrzu</h2>
        <iframe
            src="https://www.youtube.com/embed/4NC6TISKz7s" title="Poradnik o doborze oświetlenia we wnętrzu" loading="lazy" allowfullscreen>
        </iframe>
            <a href="https://www.youtube.com/watch?v=4NC6TISKz7s">Obejrzyj film na YouTube</a>
    </article>
    <article class="film">
        <h2>Jak zrobić dekoracyjny wazon?</h2>
        <iframe
            src="https://www.youtube.com/embed/QBNK7nnnTS4" title="Poradnik tworzenia dekoracyjnego wazonu" loading="lazy" allowfullscreen>
        </iframe>
            <a href="https://www.youtube.com/watch?v=QBNK7nnnTS4">Obejrzyj film na YouTube</a>
    </article>
    <article class="film">
        <h2>Jak zrobić świece zapachowe?</h2>
        <iframe
            src="https://www.youtube.com/embed/c7cyXinAbpA"
            title="Poradnik tworzenia świec zapachowych"
            loading="lazy"
            allowfullscreen>
        </iframe>
            <a href="https://www.youtube.com/watch?v=c7cyXinAbpA">Obejrzyj film na YouTube</a>
    </article>
</section>
', 1),
('o-sklepie', 'O sklepie', '<h1>O sklepie</h1>
<p>Chwila to sklep z dodatkami do wnętrz.</p>', 0);
