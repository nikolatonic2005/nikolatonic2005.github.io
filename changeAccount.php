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
$nazivquery = $konekcija->prepare('SELECT nazivBanke FROM racun WHERE idRacuna = :id');
$nazivquery->execute(['id' => $_SESSION["idRacuna"]]);
$naziv = $nazivquery->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Рачуни - ToniTracker</title>
    <link rel="stylesheet" href="css/changeAccount.css">
</head>

<body>
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a href="main.php">Преглед</a>
            <a href="transactions.php">Трансакције</a>
            <a id="accounts" href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
        </div>
    </header>
    <main>
        <?php
        if (!isset($_POST['submit'])) {
            echo <<<HTML
        <form method="post">
            <div class="welcome-div">Промени назив</div> <br>
            <div class="login-div">
                <input placeholder="$naziv" name="naziv" value="$naziv" required/>
            </div> <br>
            <div class="login-button-div">
                <button type="submit" name="submit">Потврди</button>
            </div>
        </form>
        HTML;
        } else if (isset($_POST['submit'])) {
            $nazivNov = $_POST['naziv'];
            $promeniNaziv = $konekcija->prepare('UPDATE racun SET nazivBanke = :naziv WHERE idRacuna = :id');
            $promeniNaziv->execute(["naziv" => $_POST['naziv'], "id" => $_SESSION["idRacuna"]]);
            echo <<<HTML
                <form method="post">
                    <div class="welcome-div">Промени назив</div> <br>
                    <div class="login-div">
                        <input placeholder="$nazivNov" name="naziv" value="$nazivNov" required/>
                    </div> <br>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </form>
            HTML;
            unset($_SESSION["idRacuna"]);
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