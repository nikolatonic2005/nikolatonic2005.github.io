<?php
session_start();
include 'db.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$obrisiRacun = $konekcija->prepare('DELETE FROM racun WHERE idRacuna = :id');
$obrisiRacun->execute(["id" => $_SESSION["idRacuna"]]);
echo <<<HTML
        <script>
            window.location = "accounts.php";
        </script>
    HTML;
