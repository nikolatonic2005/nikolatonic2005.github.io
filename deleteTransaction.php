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
$transakcijequery = $konekcija->prepare('SELECT IFNULL(idRacuna, 0) AS idRacuna, promenaStanja FROM transakcija WHERE idTransakcije = :id');
$transakcijequery->execute(["id" => $_SESSION["idTransakcije"]]);
$transakcije = $transakcijequery->fetchAll();
foreach ($transakcije as $temp)
    $transakcija = $temp;

if ($transakcija["idRacuna"] == 0) {
    $promeniStanje = $konekcija->prepare('UPDATE korisnik SET stanje = stanje - :iznos WHERE id = :id');
    $promeniStanje->execute(["id" => $_SESSION["id"], "iznos" => $transakcija["promenaStanja"]]);
} else {
    $promeniStanje = $konekcija->prepare('UPDATE racun SET stanje = stanje - :iznos WHERE idRacuna = :id');
    $promeniStanje->execute(["id" => $transakcija["idRacuna"], "iznos" => $transakcija["promenaStanja"]]);
}
$obrisiTransakciju = $konekcija->prepare('DELETE FROM transakcija WHERE idTransakcije = :id');
$obrisiTransakciju->execute(["id" => $_SESSION["idTransakcije"]]);

echo <<<HTML
        <script>
            window.location = "transactions.php";
        </script>
    HTML;
