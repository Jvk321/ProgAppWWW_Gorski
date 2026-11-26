<?php 
require_once __DIR__ . "/../includes/sesja.php";
header("Content-Type: text/html; charset=UTF-8");

function FormularzLogowania($csrf){

    ?>
    <form class="formularz-panelu" method="post" action="admin.php">
        <input type="hidden" name="akcja" value="logowanie">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") ?>">
        <div>
            <label for="login">Login:</label>
            <input type="text" id="login" name="login" autocomplete="username" required>
        </div>
        <div>
            <label for="haslo">Hasło:</label>
            <input type="password" id="haslo" name="haslo" autocomplete="current-password" required>
        </div>
        <button type="submit">Zaloguj</button>
    </form>
    <?php
}

function ListaPodstron($pdo){
    $zapytanie = $pdo->query("SELECT id, alias, page_title, status FROM page_list ORDER BY id");
    $podstrony = [];

    while(($podstrona = $zapytanie->fetch(PDO::FETCH_ASSOC)) !== false){
        $podstrony[] = $podstrona;
    }

    return $podstrony;
}

function EdytujPodstrone($pdo, $id, $czyPost){
    $odczyt = $pdo->prepare(
        "SELECT id, alias, page_title, page_content, status FROM page_list WHERE id = :id"
    );
    $odczyt->execute(["id" => $id]);
    $podstrona = $odczyt->fetch(PDO::FETCH_ASSOC);

    if($podstrona === false){
        http_response_code(404);
        exit("Nie znaleziono podstrony.");
    }

    if(!$czyPost){
        return $podstrona;
    }

    $tytul = $_POST["page_title"] ?? null;
    $tresc = $_POST["page_content"] ?? null;
    $publikacja = $_POST["status"] ?? null;

    if(!is_string($tytul) || !is_string($tresc) ||
        !mb_check_encoding($tytul, "UTF-8") || !mb_check_encoding($tresc, "UTF-8") ||
        ($publikacja !== null && $publikacja !== "1")){
        http_response_code(400);
        exit("Nieprawidłowe dane formularza.");
    }

    $tytul = trim($tytul);
    if($tytul === "" || mb_strlen($tytul, "UTF-8") > 255){
        http_response_code(400);
        exit("Tytuł musi mieć od 1 do 255 znaków.");
    }

    $status = $publikacja === "1" ? 1 : 0;
    if($podstrona["alias"] === "glowna" && $status === 0){
        http_response_code(409);
        exit("Strona główna musi pozostać opublikowana.");
    }

    require_once __DIR__ . "/../includes/oczysc_tresc.php";
    $tresc = trim(OczyscTresc($tresc));
    if($tresc === "" || strlen($tresc) > 60000){
        http_response_code(400);
        exit("Treść po oczyszczeniu musi mieć od 1 do 60 000 bajtów.");
    }

    $zapis = $pdo->prepare(
        "UPDATE page_list SET page_title = :tytul, page_content = :tresc, status = :status
         WHERE id = :id"
    );
    $zapis->execute([
        "tytul" => $tytul,
        "tresc" => $tresc,
        "status" => $status,
        "id" => $id
    ]);

    $_SESSION["komunikat_admin"] = "Zapisano zmiany.";
    header("Location: admin.php", true, 303);
    exit;
}

$czyPost = $_SERVER["REQUEST_METHOD"] === "POST";
$zalogowany = ($_SESSION["admin_zalogowany"] ?? false) === true;
$blad = "";

if($czyPost){
    $token = $_POST["csrf"] ?? null;
    if(!is_string($token) || !isset($_SESSION["csrf_admin"]) || !hash_equals($_SESSION["csrf_admin"], $token)){
        http_response_code(403);
        exit("Nieprawidłowy token formularza.");
    }

    $akcja = $_POST["akcja"] ?? "";
    if(!is_string($akcja)){
        http_response_code(400);
        exit("Nieprawidłowa akcja.");
    }

    if($akcja !== "logowanie" && !$zalogowany){
        http_response_code(403);
        exit("Zaloguj się do panelu.");
    }

    if($akcja === "wylogowanie"){
        unset($_SESSION["admin_zalogowany"], $_SESSION["csrf_admin"]);
        $_SESSION["komunikat_admin"] = "Wylogowano.";
        header("Location: admin.php", true, 303);
        exit;
    }

    if($akcja !== "logowanie" && $akcja !== "edytuj"){
        http_response_code(400);
        exit("Nieprawidłowa akcja.");
    }
}

$akcjaWidoku = $czyPost && $akcja === "edytuj" ? "edytuj" : "lista";

if(!$czyPost && isset($_GET["akcja"])){
    if(!$zalogowany){
        http_response_code(403);
        exit("Zaloguj się do panelu.");
    }

    $akcjaWidoku = $_GET["akcja"];
    if(!is_string($akcjaWidoku) ||
        !in_array($akcjaWidoku, ["lista", "dodaj", "edytuj", "usun"], true)){
        http_response_code(400);
        exit("Nieprawidłowa akcja.");
    }

}

if($akcjaWidoku === "edytuj" || $akcjaWidoku === "usun"){
    $id = $czyPost ? ($_POST["id"] ?? null) : ($_GET["id"] ?? null);
    if(!is_string($id) || filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id < 1){
        http_response_code(400);
        exit("Nieprawidłowy identyfikator podstrony.");
    }
    $id = (int) $id;
}

try {
    if(!is_file(__DIR__ . "/cfg_admin.php")){
        throw new RuntimeException("Brak pliku cfg_admin.php.");
    }
    require_once __DIR__ . "/cfg_admin.php";

    if($zalogowany && $akcjaWidoku === "lista"){
        $podstrony = ListaPodstron($pdoAdmin);
    }

    if($zalogowany && $akcjaWidoku === "edytuj"){
        $podstrona = EdytujPodstrone($pdoAdmin, $id, $czyPost);
    }

    if($czyPost && $akcja === "logowanie"){
        $login = $_POST["login"] ?? "";
        $haslo = $_POST["haslo"] ?? "";

        if(!is_string($login) || !is_string($haslo) || $login === "" || $login !== $loginAdmin || $haslo === "" || strlen($haslo) > 72 || strpos($haslo, "\0") !== false || !password_verify($haslo, $skrotHaslaAdmin)){
            http_response_code(400);
            $blad = "Nieprawidłowy login lub hasło";
        }else {
            if(!session_regenerate_id(true)){
                throw new RuntimeException("Nie udało się zmienić identyfikatora sesji.");
            }

            $_SESSION["admin_zalogowany"] = true;
            $_SESSION["csrf_admin"] = bin2hex(random_bytes(32));
            $_SESSION["komunikat_admin"] = "Zalogowano.";
            header("Location: admin.php", true, 303);
            exit;
        }
    }
} catch (Exception $e) {
    error_log("Panel CMS: " . $e->getMessage());
    http_response_code(500);
    exit("Wystąpił błąd serwera.");
}

if(!isset($_SESSION["csrf_admin"])){
    $_SESSION["csrf_admin"] = bin2hex(random_bytes(32));
}

$csrf = $_SESSION["csrf_admin"];
$komunikat = $_SESSION["komunikat_admin"] ?? "";
unset($_SESSION["komunikat_admin"]);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Panel CMS | Chwila</title>
        <style>
            .formularz-panelu {
                max-width: 360px;
                margin: 12px 0;
                padding: 12px;
                border: 1px solid #bbb;
            }

            .formularz-panelu div {
                margin-bottom: 10px;
            }

            .formularz-panelu label {
                display: block;
            }

            table {
                border-collapse: collapse;
            }

            th, td {
                padding: 6px 10px;
                border: 1px solid #bbb;
                text-align: left;
            }

            :focus-visible {
                outline: 2px solid #245493;
                outline-offset: 2px;
            }
        </style>
    </head>
    <body>
        <h1>Panel CMS w przygotowaniu</h1>

        <?php if($komunikat !== ""){ ?>
            <p role="status"><?= htmlspecialchars($komunikat, ENT_QUOTES, "UTF-8") ?></p>
        <?php } ?>

        <?php if($blad !== ""){ ?>
            <p role="alert"><?= htmlspecialchars($blad, ENT_QUOTES, "UTF-8") ?></p>
        <?php } ?>

        <?php if ($zalogowany) { ?>
            <form class="formularz-panelu" method="post" action="admin.php">
                <input type="hidden" name="akcja" value="wylogowanie">
                <input type="hidden" name="csrf"
                   value="<?= htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") ?>">
                <button type="submit">Wyloguj</button>
            </form>
            <?php if($akcjaWidoku === "lista"){ ?>
                <p><a href="admin.php?akcja=dodaj">Nowa podstrona</a></p>
                <table>
                    <caption>Lista podstron</caption>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Alias</th>
                            <th scope="col">Tytuł</th>
                            <th scope="col">Status</th>
                            <th scope="col">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($podstrony === []){ ?>
                            <tr><td colspan="5">Brak podstron.</td></tr>
                        <?php } ?>
                        <?php foreach($podstrony as $podstrona){ ?>
                            <?php $id = (int) $podstrona["id"]; ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= htmlspecialchars($podstrona["alias"], ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($podstrona["page_title"], ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= (int) $podstrona["status"] === 1 ? "Opublikowana" : "Szkic" ?></td>
                                <td>
                                    <a href="admin.php?akcja=edytuj&amp;id=<?= $id ?>"
                                       aria-label="Edytuj podstronę <?= $id ?>">Edytuj</a>
                                    <a href="admin.php?akcja=usun&amp;id=<?= $id ?>"
                                       aria-label="Usuń podstronę <?= $id ?>">Usuń</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php }elseif($akcjaWidoku === "edytuj"){ ?>
                <h2>Edytuj podstronę</h2>
                <p>Alias: <?= htmlspecialchars($podstrona["alias"], ENT_QUOTES, "UTF-8") ?></p>

                <form class="formularz-panelu" method="post" action="admin.php">
                    <input type="hidden" name="akcja" value="edytuj">
                    <input type="hidden" name="id" value="<?= (int) $podstrona["id"] ?>">
                    <input type="hidden" name="csrf"
                           value="<?= htmlspecialchars($csrf, ENT_QUOTES, "UTF-8") ?>">

                    <div>
                        <label for="page_title">Tytuł</label>
                        <input type="text" id="page_title" name="page_title" required
                               value="<?= htmlspecialchars($podstrona["page_title"], ENT_QUOTES, "UTF-8") ?>">
                    </div>

                    <div>
                        <label for="page_content">Treść HTML</label>
                        <textarea id="page_content" name="page_content" rows="12" required><?= htmlspecialchars($podstrona["page_content"], ENT_QUOTES, "UTF-8") ?></textarea>
                    </div>

                    <div>
                        <label for="status">
                            <input type="checkbox" id="status" name="status" value="1"
                                   <?= (int) $podstrona["status"] === 1 ? "checked" : "" ?>>
                            Opublikowana
                        </label>
                    </div>

                    <button type="submit">Zapisz</button>
                    <a href="admin.php">Anuluj</a>
                </form>
            <?php }else{ ?>
                <p>Ta akcja zostanie udostępniona w dalszej części laboratorium.</p>
                <p><a href="admin.php">Wróć do listy</a></p>
            <?php } ?>
        <?php } else { 
                FormularzLogowania($csrf); 
              } 
        ?>
        <a href="../index.php">Wróć do sklepu</a>
    </body>
</html>
