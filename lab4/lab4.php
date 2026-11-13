<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Katalog PHP</title>
    <link rel="stylesheet" href="./css/style4.css">
</head>
<body>
    <?php
        require_once __DIR__ . '/includes/produkty.php';

        $grupa = "PRODUKTY";
        include __DIR__ . '/includes/naglowek.php';

        echo "<h2>Katalog PHP</h2>";
        echo "<p>Identyfikator grupy: $grupa</p>";
    ?>
    <a href="./index4.html">Powrót do strony głównej</a>
</body>
</html>