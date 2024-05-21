<?php
session_start();
$_SESSION["id"] = '';
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
    <link rel="stylesheet" href="css/begin.css">
    <title>ToniTracker</title>
</head>

<body>
    <main>
        <div class="begin-div">
            <div class="welcome-div">Добродошли</div>
            <div class="about-div">ToniTracker је web апликација намењена за ефикасно праћење личног буџета, што укључује готовину и банковни рачун. Омогућава бележење трансакција и њихов приказ кроз разне графиконе.</div>
            <div class="log-sign-div">
                <a href="register.php">Регистрација</a>
                <a href="login.php">Пријава</a>
            </div>
            <div>
    </main>
</body>

</html>