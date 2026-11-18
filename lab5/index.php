<?php
    $idetyfikator = "chwila";

    $widoki = [
    "glowna" => [
        "tytul" => "Home",
        "plik" => __DIR__ . "/html/glowna.html"
    ],
    "kontakt" => [
        "tytul" => "Kontakt",
        "plik" => __DIR__ . "/html/kontakt.html"
    ],
    "produkt" => [
        "tytul" => "Produkt",
        "plik" => __DIR__ . "/html/produkt.html"
    ],
    "filmy" => [
        "tytul" => "Filmy",
        "plik" => __DIR__ . "/html/filmy.html"
    ]
];

$idp = "glowna";

if(isset($_GET["idp"]) && is_string($_GET["idp"])){
    if(isset($widoki[$_GET["idp"]])){
        $idp = $_GET["idp"];
    }
}

?>
<!DOCTYPE html>
<html lang="pl" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/style4.css" rel="stylesheet">
        <script src="./vendor/jquery-4.0.0.min.js" defer></script>
        <script src="js/main3.js" defer></script>
        <title><?php echo htmlspecialchars($widoki[$idp]["tytul"], ENT_QUOTES, "UTF-8"); ?> | Chwila</title>
    </head>
    <body>
         <header>
            <nav>
                <img src="./img/logo/chwila_logo_glowne.svg" alt="logo firmy chwila" width="300px">
               <ul>
                <?php
                    foreach($widoki as $id => $widok){
                        echo '<li><a href="index.php?idp=' . $id . '"';
                        if($idp === $id){
                            echo ' aria-current="page"';
                        }
                        echo '>' . htmlspecialchars($widok["tytul"], ENT_QUOTES, "UTF-8") . '</a></li>';
                    }
                ?>
                <li><a href="lab4.php">Katalog PHP</a></li>
                <button type="button" id="theme" class="button-style-one" aria-pressed="false" >Tryb ciemny</button>
               </ul>
            </nav>
        </header>

        <div class="clock-pos">
            <div id="clock"></div>
            <button type="button" id="start-clock" class="button-style-one">Start zegara</button>
            <button type="button" id="stop-clock" class="button-style-one">Stop zegara</button>
        </div>

        <main>
            <?php 
                include $widoki[$idp]["plik"];
            ?>
        </main>

        <footer>
            <div class="top-footer">
                <h3>Kontakt</h3>
                <p>kontakt@chwila.com</p>
                <p>+48 123 456 789</p>
                <p>Olsztyn, Polska</p>
            </div>
            <div class="bottom-footer">
                <p>&copy; 2026 Chwila. Wszelkie prawa zastrzeżone.</p>
                <p>Identyfikator projektu: <?php echo $idetyfikator; ?></p>
            </div>
        </footer>
    </body>
</html>