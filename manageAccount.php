<?php
session_start();
include 'writeFuncs/writeManageAccount.php';
include 'db.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$korisnikquery = $konekcija->prepare('SELECT * FROM korisnik WHERE id = :id');
$korisnikquery->execute(["id" => $_SESSION["id"]]);
$korisnici = $korisnikquery->fetchAll();
foreach ($korisnici as $temp)
    $korisnik = $temp;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/manageAccount.css">
    <title>Управљање налогом</title>
</head>

<body>
    
    <?php
    $ime = $korisnik["ime"];
    $prezime = $korisnik["prezime"];
    $email = $korisnik["email"];
    $password = $korisnik["password"];
    if (!isset($_POST['change']))
        ispisi($korisnik);
    if (isset($_POST['change']) and $_POST["password"] != $_POST["repassword"]) {
        ispisiGreska($korisnik);
    }
    if (isset($_POST['change']) and $_POST["password"] == $_POST["repassword"]) {
        ispisi($korisnik);
        if ($_POST["ime"] != '') {
            $ime = $_POST["ime"];
            $_SESSION["name"] = $_POST["ime"];
        }
        if ($_POST["prezime"] != '')
            $prezime = $_POST["prezime"];
        if ($_POST["email"] != '')
            $email = $_POST["email"];
        if ($_POST["password"] != '')
            $password = PASSWORD_HASH($_POST['password'], PASSWORD_DEFAULT);
        $update = $konekcija->prepare('UPDATE korisnik SET ime = :ime, prezime = :prezime, email = :email, password = :password WHERE id = :id');
        $update->execute(["ime" => $ime, "prezime" => $prezime, "email" => $email, "password" => $password, "id" => $_SESSION["id"]]);
        echo <<<HTML
            <script>
                window.location = 'main.php';
            </script>
        HTML;
    }
    ?>
</body>

</html>