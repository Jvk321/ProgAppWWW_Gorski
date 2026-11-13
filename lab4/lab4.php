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

        require_once __DIR__ . '/includes/produkty.php';
    ?>
    <a href="./index4.html">Powrót do strony głównej</a>
</body>
</html>