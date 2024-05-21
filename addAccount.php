<?php
session_start();
include 'db.php';
include 'writeFuncs/writeAddAccount.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addAccount.css">
    <title>Додај рачун</title>
</head>

<body>
    <?php
    if (!isset($_POST['submit'])) {
        ispisi();
    } else if (isset($_POST['submit'])) {
        ispisi();
        $stanje = str_replace(",", ".", $_POST["stanje"]);
        $ubaciRacun = $konekcija->prepare('INSERT INTO racun (idKorisnika, nazivBanke, stanje) VALUES (:id, :naziv, :stanje)');
        $ubaciRacun->execute(["id" => $_SESSION["id"], "naziv" => $_POST["naziv"], "stanje" => $stanje]);
        echo <<<HTML
                <script>
                    window.location = "accounts.php";
                </script>
            HTML;
    }
    ?>
    </main>

</body>

</html>