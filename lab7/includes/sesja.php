<?php
$czyHttps = !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] != "off";

session_set_cookie_params([
    "path" => "/",
    "secure" => $czyHttps,
    "httponly" => true,
    "samesite" => "Lax"
]);

session_start();