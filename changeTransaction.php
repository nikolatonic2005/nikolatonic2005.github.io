<?php
session_start();
include 'db.php';
include 'writeFuncs/writeChangeTransaction.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$transakcijequery = $konekcija->prepare('SELECT idTransakcije, promenaStanja, datum, opis, IFNULL(idRacuna, 0) AS idRacuna FROM transakcija WHERE idTransakcije = :id');
$transakcijequery->execute(['id' => $_SESSION["idTransakcije"]]);
$transakcije = $transakcijequery->fetchAll();
foreach ($transakcije as $temp)
    $transakcija = $temp;

$naziviRacunaquery = $konekcija->prepare('SELECT idRacuna, nazivBanke FROM racun WHERE idKorisnika = :id');
$naziviRacunaquery->execute(['id' => $_SESSION["id"]]);
$naziviRacuna = $naziviRacunaquery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/changeTransaction.css">
    <title>Измени трансакцију</title>
</head>

<body>
    <script>
        window.addEventListener("load", function() {
            var name = "<?php echo $transakcija["datum"]; ?>";
            var datetimeField = document.getElementById("datum");
            datetimeField.value = name;
        });
    </script>

    <?php
    if (!isset($_POST['submit'])) {
        ispisi($transakcija, $naziviRacuna);
    } else if (isset($_POST['submit'])) {
        ispisi($transakcija, $naziviRacuna);
        $iznos = str_replace(",", ".", $_POST["iznos"]);
        if ($_POST["racun"] == 0) {
            $ubaciTransakciju = $konekcija->prepare('UPDATE transakcija SET promenaStanja = :promena, idRacuna = null, datum = :datum, opis = :opis WHERE idTransakcije = :id');
            $ubaciTransakciju->execute(["promena" => $iznos, "datum" => $_POST["datum"], "opis" => $_POST["opis"], "id" => $_SESSION["idTransakcije"]]);
            $promeniStanje = $konekcija->prepare('UPDATE korisnik SET stanje = stanje - :prviiznos + :drugiiznos WHERE id = :id');
            $promeniStanje->execute(["id" => $_SESSION["id"], "prviiznos" => $transakcija["promenaStanja"], "drugiiznos" => $iznos]);
        } else {
            $ubaciTransakciju = $konekcija->prepare('UPDATE transakcija SET promenaStanja = :promena, idRacuna = :idRacuna, datum = :datum, opis = :opis WHERE idTransakcije = :id');
            $ubaciTransakciju->execute(["idRacuna" => $_POST["racun"], "promena" => $iznos, "datum" => $_POST["datum"], "opis" => $_POST["opis"], "id" => $_SESSION["idTransakcije"]]);
            $promeniStanje = $konekcija->prepare('UPDATE racun SET stanje = stanje - :prviiznos + :drugiiznos WHERE idRacuna = :id');
            $promeniStanje->execute(["id" => $_POST["racun"], "prviiznos" => $transakcija["promenaStanja"], "drugiiznos" => $iznos]);
        }

        echo <<<HTML
                <script>
                    window.location = "transactions.php";
                </script>
            HTML;
    }
    ?>
    </main>

</body>

</html>