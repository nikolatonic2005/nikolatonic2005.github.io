<?php
session_start();
include 'db.php';
include 'writeFuncs/writeAccounts.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$racuniquery = $konekcija->prepare('SELECT * FROM racun WHERE idKorisnika = :id');
$racuniquery->execute(['id' => $_SESSION["id"]]);
$racuni = $racuniquery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рачуни - ToniTracker</title>
    <link rel="stylesheet" href="css/accounts.css">
</head>

<body>
    <?php
    if (!isset($_POST['change']) and !isset($_POST['delete'])) {
        ispisi($racuni);
    } else if (isset($_POST['change'])) {
        $_SESSION["idRacuna"] = $_POST['change'];
        echo <<<HTML
                <script>
                    window.location = "changeAccount.php";
                </script>
            HTML;
    } else if (isset($_POST['delete'])) {
        ispisi($racuni);
        $_SESSION["idRacuna"] = $_POST['delete'];
        echo <<<HTML
                <script>
                    if (confirm('Јесте ли сигурни?')) {
                        window.location = "deleteAccount.php";
                    }
                    else {
                        window.location = "accounts.php";
                    }
                </script>
            HTML;
    }
    ?>
</body>

</html>