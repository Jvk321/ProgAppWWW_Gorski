<?php
$host = "127.0.0.1";
$port = 3306;
$baza = "moja_strona";
$uzytkownik = "";
$haslo = "";

$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$baza;charset=utf8mb4",
    $uzytkownik,
    $haslo,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]
);
