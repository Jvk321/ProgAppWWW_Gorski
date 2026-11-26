<?php
$loginAdmin = "";
$skrotHaslaAdmin = "";

$hostAdmin = "127.0.0.1";
$portAdmin = 3306;
$bazaAdmin = "moja_strona";
$uzytkownikAdmin = "";
$hasloBazyAdmin = "";

$pdoAdmin = new PDO(
    "mysql:host=$hostAdmin;port=$portAdmin;dbname=$bazaAdmin;charset=utf8mb4",
    $uzytkownikAdmin,
    $hasloBazyAdmin,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);