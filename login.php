<?php
session_start();
include 'db.php';
$konekcija = connectDB();
if ($_SESSION["id"] != '') {
    echo <<<html
        <script>
            window.location = "main.php"
        </script>
        html;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Пријава</title>
</head>

<body>
    <main>
        <?php
        if (!isset($_POST['submit'])) {
            echo <<< HTML
            <form method="post">
                <div class="naslov-div"><span>Пријава</span></div>
                <div class="login-div">
                        <input placeholder="Корисничко име" name="email" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Лозинка" name="password" required type="password"/>
                    </div>
                    <div class="reg-div">
                        <span>Немате налог?</span>
                        <a href="register.php">Направите га</a>
                    </div>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </div>
            </form>
        HTML;
        } else if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $userIDquery = $konekcija->prepare('SELECT id FROM korisnik where email = :email');
            $userIDquery->execute(['email' => $email]);
            $_SESSION["id"] = $userIDquery->fetchColumn();

            $passwordhashquery = $konekcija->prepare('SELECT password FROM korisnik where id = :id');
            $passwordhashquery->execute(['id' => $_SESSION["id"]]);
            $passwordhash = $passwordhashquery->fetchColumn();

            if (!password_verify($_POST['password'], $passwordhash)) {
                echo <<< HTML
                    <form method="post">
                    <div class="naslov-div"><span>Пријава</span></div>
                    <div class="login-div">
                        <span>Неисправни подаци</span>
                    </div>
                    <div class="login-div">
                        <input placeholder="Корисничко име" name="email" value="$email" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Лозинка" name="password" required type="password"/>
                    </div>
                    <div class="reg-div">
                        <span>Немате налог?</span>
                        <a href="register.php">Направите га</a>
                    </div>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </div>
            </form>
        HTML;
            } else {
                $namequery = $konekcija->prepare('SELECT ime FROM korisnik where id = :id');
                $namequery->execute(['id' => $_SESSION["id"]]);
                $_SESSION["name"] = $namequery->fetchColumn();

                $surnamequery = $konekcija->prepare('SELECT prezime FROM korisnik where id = :id');
                $surnamequery->execute(['id' => $_SESSION["id"]]);
                $_SESSION["surname"] = $surnamequery->fetchColumn();

                echo '<script type="text/javascript"> window.location = "main.php"    </script>';
            }
        }
        ?>
    </main>
</body>

</html>