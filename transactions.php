<?php
session_start();
include "db.php";
include "writeFuncs/writeTransactions.php";
$konekcija = connectDB();
if ($_SESSION["id"] == "") {
    echo <<<html
<script>
    window.location = "begin.php"
</script>
html;
}
$br = 1;
$transakcijequery = $konekcija->prepare('SELECT idTransakcije, promenaStanja, datum, IFNULL(opis, "-") AS opis, IFNULL(idRacuna, 0) AS idRacuna
    FROM transakcija WHERE idKorisnika = :id ORDER BY datum DESC');
$transakcijequery->execute(["id" => $_SESSION["id"]]);
$transakcije = $transakcijequery->fetchAll();

$naziviRacunaquery = $konekcija->prepare(
    "SELECT idRacuna, nazivBanke FROM racun WHERE idKorisnika = :id"
);
$naziviRacunaquery->execute(["id" => $_SESSION["id"]]);
$naziviRacuna = $naziviRacunaquery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/transactions.css">
    <title>Трансакције - ToniTracker</title>
</head>

<body>
    <?php if (!isset($_POST["change"]) and !isset($_POST["delete"])) {
        ispisi($naziviRacuna, $transakcije, $br);
    } elseif (isset($_POST["change"])) {
        $_SESSION["idTransakcije"] = $_POST["change"];
        echo <<<HTML
    <script>
        window.location = "changeTransaction.php";
    </script>
HTML;
    } elseif (isset($_POST["delete"])) {
        ispisi($naziviRacuna, $transakcije, $br);
        $_SESSION["idTransakcije"] = $_POST["delete"];
        echo <<<HTML
    <script>
        if (confirm('Јесте ли сигурни?')) {
            window.location = "deleteTransaction.php";
        }
        else {
            window.location = "transactions.php";
        }
    </script>
HTML;
    } ?>
</body>

</html>