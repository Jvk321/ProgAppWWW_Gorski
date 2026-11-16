<?php
    session_start();
    require_once __DIR__ . '/includes/produkty.php';

    $bladPost = "";
    $bladPostProdukt = null;
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        if(isset($_POST["produkt"]) && isset($_POST["ilosc"])){
            if(is_string($_POST["produkt"]) && is_string($_POST["ilosc"])){
                $produkt = filter_var($_POST["produkt"], FILTER_VALIDATE_INT);
                $ilosc = filter_var($_POST["ilosc"], FILTER_VALIDATE_INT);
                if($produkt !== false && $ilosc !== false){
                    if($ilosc >= 1 && $ilosc <= 5){
                        $wybor = false;
                        foreach($produkty as $p){
                            if($p["id"]===$produkt && $ilosc <= $p["stan"]){
                                $wybor = true;
                                break;
                            }
                        }
                        if($wybor){
                            $_SESSION["ostatni_wybor"] = [
                                "produkt" => $produkt,
                                "ilosc" => $ilosc
                            ];

                            header("Location: lab4.php", true, 303);
                            exit;
                        }
                    }
                }
            }
        }
        http_response_code(400);
        $bladPost = "Nieprawidłowy produkt lub ilość.";
        if (isset($_POST["produkt"]) && is_string($_POST["produkt"])) {
            $idBledu = filter_var($_POST["produkt"], FILTER_VALIDATE_INT);
            foreach ($produkty as $p) {
                if ($idBledu !== false && $p["id"] === $idBledu) {
                    $bladPostProdukt = $idBledu;
                    break;
                }
            }
        }
    }

    $blad = "";
    $kategoria = "wszystkie";
    if(isset($_GET["kategoria"])){
        if(is_string($_GET["kategoria"])){
            if(in_array($_GET["kategoria"], ["wszystkie", "ksiazki", "akcesoria"], true)){
                $kategoria = $_GET["kategoria"];
            }else{
                $blad = "Nieprawidłowa kategoria!";
            }
            }else{
                $blad = "Nieprawidłowa kategoria!";
            }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Katalog PHP</title>
</head>
<body>
    <?php
        $grupa = "PRODUKTY";
        include __DIR__ . '/includes/naglowek.php';

        echo "<h2>Katalog PHP</h2>";
        echo "<p>Identyfikator grupy: $grupa</p>";
    ?>
    <form action="lab4.php" method="get">
        <label for="kategoria">Kategoria:</label>
        <select name="kategoria" id="kategoria">
            <option value="wszystkie">Wszystkie</option>
            <option value="ksiazki">Książki</option>
            <option value="akcesoria">Akcesoria</option>
        </select>
        <button type="submit">Filtruj</button>
    </form>
    <?php
    if ($bladPost !== "" && $bladPostProdukt === null) {
        echo "<p>" . htmlspecialchars($bladPost, ENT_QUOTES, "UTF-8") . "</p>";
    }
    if ($blad !== "") {
        echo "<p>$blad</p>";
    }
    $i = 0;
    while($i < count($produkty)){
        if($kategoria === "wszystkie" || $produkty[$i]["kategoria"] === $kategoria){
            echo "<p>" . htmlspecialchars($produkty[$i]["nazwa"], ENT_QUOTES, "UTF-8") . "</p>";
            if($produkty[$i]["stan"] === 0){
                echo "<p>Niedostępny</p>";
            }elseif($produkty[$i]["stan"] >= 1 && $produkty[$i]["stan"] <= 5){
                echo "<p>Niski stan</p>";
            }else{
                echo "<p>Dostępny</p>";
            }

            switch($produkty[$i]["kategoria"]){
                case "ksiazki":
                    echo "<p>Książki</p>";
                    break;
                case "akcesoria":
                    echo "<p>Akcesoria</p>";
                    break;
            }
            echo "<form action='lab4.php' method='post'>";
            echo "<label for='ilosc-$i'>Liczba sztuk:</label>";
            echo "<select name='ilosc' id='ilosc-$i'>";
            for($j = 1; $j <= 5; $j++){
                echo "<option value='$j'>$j</option>";
            }
            echo "</select>";
            echo "<input type='hidden' name='produkt' value='{$produkty[$i]["id"]}'>";
            if ($bladPost !== "" && $bladPostProdukt === $produkty[$i]["id"]){
                echo "<p>" . htmlspecialchars($bladPost, ENT_QUOTES, "UTF-8") . "</p>";
            }        
            echo "<button type='submit'>Zapisz wybór</button>";
            echo "</form>";
        }
        $i++;
    }
    if(isset($_SESSION["ostatni_wybor"])) {
        $produkt = $_SESSION["ostatni_wybor"]["produkt"];
        $ilosc = $_SESSION["ostatni_wybor"]["ilosc"];
        foreach ($produkty as $p) {
            if ($p["id"] === $produkt) {
                echo "<p>Ostatnio wybrany produkt: " . htmlspecialchars($p["nazwa"], ENT_QUOTES, "UTF-8") . "</p>";
                echo "<p>Liczba sztuk: " . $ilosc . "</p>";
                break;
            }
        }
    } else {
        echo "<p>Nie wybrano jeszcze produktu</p>";
    }
    ?>
    <a href="./index4.html">Powrót do strony głównej</a>
</body>
</html>