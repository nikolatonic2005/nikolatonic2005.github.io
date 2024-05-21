<?php
function ispisi($korisnik)
{
    echo <<<HTML
    <script>
    function potvrdi() {
        if (confirm('Јесте ли сигурни?')) {
            window.location = "deleteUser.php";
        }
        else {
            window.location = "manageAccount.php";
        }
    }
    </script>
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a id="pregled" href="main.php">Преглед</a>
            <a href="transactions.php">Трансакције</a>
            <a href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
            <a id="manage" href="manageAccount.php">Управљање налогом</a>
    </div>
    </header>
    <main>
        <form method="post">
            <div class="naslov-div"><span>Измените податке</span></div>
            <div class="login-div">
                <input placeholder=$korisnik[ime] name="ime">
            </div>
            <div class="login-div">
                <input placeholder=$korisnik[prezime] name="prezime">
            </div>
            <div class="login-div">
                <input placeholder=$korisnik[email] name="email">
            </div>
            <div class="login-div">
                <input placeholder="Нова лозинка" name="password" type="password" />
            </div>
            <div class="login-div">
                <input placeholder="Поновите лозинку" name="repassword" type="password" />
            </div>
            <div class="reg-div">
                <span></span>
                <br>
            </div>
            <div class="login-button-div">
                <button type="submit" name="change">Потврди</button>  <br><br>
                <button type="button" onclick="potvrdi()">Обришите налог</button>
            </div>
        </form>
    </main>
    HTML;
}

function ispisiGreska($korisnik)
{
    echo <<<HTML
    <script>
    function potvrdi() {
        if (confirm('Јесте ли сигурни?')) {
            window.location = "deleteUser.php";
        }
        else {
            window.location = "manageAccount.php";
        }
    }
    </script>
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a id="pregled" href="main.php">Преглед</a>
            <a href="transactions.php">Трансакције</a>
            <a href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
            <a id="manage" href="manageAccount.php">Управљање налогом</a>
    </div>
    </header>
    <main>
        <form method="post">
            <div class="naslov-div"><span>Измените податке</span></div>
            Лозинке се не поклапају
            <div class="login-div">
                <input placeholder=$korisnik[ime] name="ime">
            </div>
            <div class="login-div">
                <input placeholder=$korisnik[prezime] name="prezime">
            </div>
            <div class="login-div">
                <input placeholder=$korisnik[email] name="email">
            </div>
            <div class="login-div">
                <input placeholder="Нова лозинка" name="password" type="password" />
            </div>
            <div class="login-div">
                <input placeholder="Поновите лозинку" name="repassword" type="password" />
            </div>
            <div class="reg-div">
                <span></span>
                <br>
            </div>
            <div class="login-button-div">
                <button type="submit" name="change">Потврди</button>  <br><br>
                <button type="button" onclick=potvrdi()>Обришите налог</button>
            </div>
        </form>
    </main>
    HTML;
}