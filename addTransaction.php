<?php
session_start();
include 'db.php';
include 'writeFuncs/writeAddTransaction.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$naziviRacunaquery = $konekcija->prepare('SELECT idRacuna, nazivBanke FROM racun WHERE idKorisnika = :id');
$naziviRacunaquery->execute(['id' => $_SESSION["id"]]);
$naziviRacuna = $naziviRacunaquery->fetchAll();

$stanjaQuery = $konekcija->prepare('SELECT idRacuna, stanje FROM racun WHERE idKorisnika = :id');
$stanjaQuery->execute(['id' => $_SESSION["id"]]);
$stanja = $stanjaQuery->fetchAll();

$novcanikQuery = $konekcija->prepare('SELECT stanje FROM korisnik WHERE id = :id');
$novcanikQuery->execute(['id' => $_SESSION["id"]]);
$novcanik = $novcanikQuery->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addAccount.css">
    <title>Додај трансакцију</title>
</head>

<body>
    <script>
        window.addEventListener("load", function() {
            var now = new Date();
            var utcString = now.toISOString().substring(0, 19);
            var year = now.getFullYear();
            var month = now.getMonth() + 1;
            var day = now.getDate();
            var hour = now.getHours();
            var minute = now.getMinutes();
            var second = now.getSeconds();
            var localDatetime = year + "-" +
                (month < 10 ? "0" + month.toString() : month) + "-" +
                (day < 10 ? "0" + day.toString() : day) + "T" +
                (hour < 10 ? "0" + hour.toString() : hour) + ":" +
                (minute < 10 ? "0" + minute.toString() : minute) +
                utcString.substring(16, 19);
            var datetimeField = document.getElementById("datum");
            datetimeField.value = localDatetime;
        });
    </script>
    <?php
    if (!isset($_POST['submit'])) {
        ispisi($naziviRacuna);
    } else if (isset($_POST['submit'])) {
        $iznos = str_replace(",", ".", $_POST["iznos"]);
        foreach ($stanja as $temp) {
            if ($temp["idRacuna"] == $_POST["racun"]) {
                $stanje = $temp;
                break;
            }
        }
        if ($_POST["racun"] != 0) {
            if ($iznos * (-1) > $stanje["stanje"]) {
                ispisiGreska($naziviRacuna);
            } else {
                ispisi($naziviRacuna);
                $ubaciTransakciju = $konekcija->prepare('INSERT INTO transakcija (idKorisnika, promenaStanja, idRacuna, datum, opis) VALUES (:id, :iznos, :racun, :datum, :opis)');
                $ubaciTransakciju->execute(["id" => $_SESSION["id"], "iznos" => $iznos, "racun" => $_POST["racun"], "datum" => $_POST["datum"], "opis" => $_POST["opis"]]);
                $promeniStanje = $konekcija->prepare('UPDATE racun SET stanje = stanje + :iznos WHERE idRacuna = :id');
                $promeniStanje->execute(["id" => $_POST["racun"], "iznos" => $iznos]);
                echo <<<HTML
                <script>
                    window.location = "transactions.php";
                </script>
            HTML;
            }
        }
        if ($_POST["racun"] == 0) {
            if ($iznos * (-1) > $novcanik) {
                ispisiGreska($naziviRacuna);
            } else {
                ispisi($naziviRacuna);
                $ubaciTransakciju = $konekcija->prepare('INSERT INTO transakcija (idKorisnika, promenaStanja, datum, opis) VALUES (:id, :iznos, :datum, :opis)');
                $ubaciTransakciju->execute(["id" => $_SESSION["id"], "iznos" => $iznos, "datum" => $_POST["datum"], "opis" => $_POST["opis"]]);
                $promeniStanje = $konekcija->prepare('UPDATE korisnik SET stanje = stanje + :iznos WHERE id = :id');
                $promeniStanje->execute(["id" => $_SESSION["id"], "iznos" => $iznos]);
                echo <<<HTML
                <script>
                    window.location = "transactions.php";
                </script>
            HTML;
            }
        }
    }
    ?>
    </main>

</body>

</html>