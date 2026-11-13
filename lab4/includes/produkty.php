<?php
$produkty = [
    ["id" => 1, "nazwa" => "Lampka nocna led", "kategoria" => "akcesoria", "stan" => 0],
    ["id" => 2, "nazwa" => "Wazon ceramiczny", "kategoria" => "akcesoria", "stan" => 1],
    ["id" => 3, "nazwa" => "Świeca zapachowa", "kategoria" => "akcesoria", "stan" => 5],
    ["id" => 4, "nazwa" => "php", "kategoria" => "ksiazki", "stan" => 7]
];

$i = 0;
while($i < count($produkty)){

    echo "<p>" . $produkty[$i]["nazwa"] . "</p>";

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
    
    echo "<form method='get'>";
    echo "<label for='ilosc-$i'>Liczba sztuk:</label>";
    echo "<select name='ilosc' id='ilosc-$i'>";
    for($j = 1; $j <= 5; $j++){
        echo "<option value='$j'>$j</option>";
    }
    echo "</select>";
    echo "</form>";
    $i++;
}