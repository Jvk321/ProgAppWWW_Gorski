<?php
require_once __DIR__ . "/showpage.php";

$idetyfikator = "chwila";
$alias = $_GET["idp"] ?? "glowna";
if ($alias === "") {
    $alias = "glowna";
}

$strona = null;
$menu = [];
$bladWidoku = "";

try {
    if (!is_file(__DIR__ . "/cfg.php")) {
        throw new RuntimeException("Brak pliku cfg.php.");
    }
    require_once __DIR__ . "/cfg.php";

    $menu = $pdo->query("SELECT alias, page_title FROM page_list WHERE status = 1 ORDER BY id")
        ->fetchAll(PDO::FETCH_ASSOC);

    if (is_string($alias) && preg_match('/\A[a-z0-9-]{1,20}\z/', $alias)) {
        $strona = PokazPodstrone($pdo, $alias);
    }

    if ($strona === null) {
        http_response_code(404);
        $bladWidoku = "Nie znaleziono podstrony.";
    }
} catch (Exception $e) {
    error_log("Chwila CMS: " . $e->getMessage());
    http_response_code(500);
    $bladWidoku = "Wystąpił błąd serwera.";
}

$tytul = $strona["page_title"] ?? "Błąd";
?>
<!DOCTYPE html>
<html lang="pl" data-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./css/style4.css" rel="stylesheet">
        <script src="./vendor/jquery-4.0.0.min.js" defer></script>
        <script src="js/main3.js" defer></script>
        <title><?php echo htmlspecialchars($tytul, ENT_QUOTES, "UTF-8"); ?> | Chwila</title>
    </head>
    <body>
         <header>
            <nav>
                <img src="./img/logo/chwila_logo_glowne.svg" alt="logo firmy chwila" width="300px">
               <ul>
                <?php
                    foreach ($menu as $pozycja) {
                        echo '<li><a href="index.php?idp=' . urlencode($pozycja["alias"]) . '"';
                        if ($strona !== null && $alias === $pozycja["alias"]) {
                            echo ' aria-current="page"';
                        }
                        echo '>' . htmlspecialchars($pozycja["page_title"], ENT_QUOTES, "UTF-8") . '</a></li>';
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
                if ($strona !== null) {
                    echo $strona["page_content"];
                } else {
                    echo "<p>" . htmlspecialchars($bladWidoku, ENT_QUOTES, "UTF-8") . "</p>";
                    echo '<a href="index.php">Powrót do strony głównej</a>';
                }
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
                <p>Identyfikator projektu: <?php echo $idetyfikator; ?> | v1.6</p>
            </div>
        </footer>
    </body>
</html>
