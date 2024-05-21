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
    <title>Регистрација</title>
</head>

<body>
    <main>
        <?php
        if (!isset($_POST['submit'])) {
            echo <<< HTML
                <form method="post">
                    <div class="naslov-div"><span>Регистрација</span></div>
                    <div class="login-div">
                        <input placeholder="Име" name="ime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Презиме" name="prezime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Корисничко име" name="email" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Стање у новчанику (готовина)" name="stanje" type="number" step="0.01" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Лозинка" name="password" required type="password"/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Поновите лозинку" name="repassword" required type="password"/>
                    </div>
                    <div class="reg-div">
                        <span>Имате налог?</span>
                        <a href="login.php">Пријавите се</a>
                    </div>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </form>
            HTML;
        } else if (isset($_POST['submit'])) {
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $stanje = $_POST['stanje'];
            $repassword = $_POST['repassword'];

            $checkemailquery = $konekcija->prepare('SELECT DISTINCT email FROM korisnik WHERE email = :email');
            $checkemailquery->execute(['email' => $email]);
            $checkemail = $checkemailquery->fetchColumn();

            if ($password != $repassword) {
                echo <<< HTML
                <form method="post">
                    <div class="naslov-div"><span>Регистрација</span></div>
                    <div class="login-div">
                        <span>Лозинке се не поклапају</span>
                    </div>
                    <div class="login-div">
                        <input placeholder="Име" name="ime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Презиме" name="prezime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Корисничко име" name="email" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Стање у новчанику (готовина)" name="stanje" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Лозинка" name="password" required type="password"/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Поновите лозинку" name="repassword" required type="password"/>
                    </div>
                    <div class="reg-div">
                        <span>Имате налог?</span>
                        <a href="login.php">Пријавите се</a>
                    </div>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </form>
            HTML;
            } else if ($email == $checkemail) {
                echo <<< HTML
                <form method="post">
                    <div class="naslov-div"><span>Регистрација</span></div>
                    <div class="login-div">
                        <span>Email адреса је већ у употреби</span>
                    </div>
                    <div class="login-div">
                        <input placeholder="Име" name="ime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Презиме" name="prezime" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Корисничко име" name="email" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Стање у новчанику (готовина)" name="stanje" required/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Лозинка" name="password" required type="password"/>
                    </div>
                    <div class="login-div">
                        <input placeholder="Поновите лозинку" name="repassword" required type="password"/>
                    </div>
                    <div class="reg-div">
                        <span>Имате налог?</span>
                        <a href="login.php">Пријавите се</a>
                    </div>
                    <div class="login-button-div">
                        <button type="submit" name="submit">Потврди</button>
                    </div>
                </form>
            HTML;
            } else {
                $password = PASSWORD_HASH($_POST['password'], PASSWORD_DEFAULT);
                $insert = $konekcija->prepare('INSERT INTO korisnik (ime, prezime, email, password, stanje) VALUES (:ime, :prezime, :email, :pass, :stanje)');
                $insert->execute(['ime' => $ime, 'prezime' => $prezime, 'email' => $email, 'pass' => $password, 'stanje' => $stanje]);

                $userIDquery = $konekcija->prepare('SELECT id FROM korisnik where email = :email');
                $userIDquery->execute(['email' => $email]);
                $_SESSION["id"] = $userIDquery->fetchColumn();

                $namequery = $konekcija->prepare('SELECT ime FROM korisnik where id = :id');
                $namequery->execute(['id' => $_SESSION["id"]]);
                $_SESSION["name"] = $namequery->fetchColumn();

                $surnamequery = $konekcija->prepare('SELECT prezime FROM korisnik where id = :id');
                $surnamequery->execute(['id' => $_SESSION["id"]]);
                $_SESSION["surname"] = $surnamequery->fetchColumn();

                echo <<< HTML
                <script>
                    window.location = "main.php";
                </script>
                HTML;
            }
        }
        ?>
    </main>
</body>

</html>