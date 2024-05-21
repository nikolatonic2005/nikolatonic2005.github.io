<?php
function ispisi($transakcija, $naziviRacuna)
{
    echo <<<HTML
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a href="main.php">Преглед</a>
            <a id="transaction" href="transactions.php">Трансакције</a>
            <a href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
            <a href="manageAccount.php">Управљање налогом</a>
        </div>
    </header>
    <main>
        <form method="post">
            <div class="welcome-div">Измени трансакцију</div> <br>
            <div class="login-div">
                <input placeholder=$transakcija[promenaStanja] value=$transakcija[promenaStanja] name="iznos" type="number" step="0.01" required>
            </div>
            <div class="login-div">
            <select name="racun" id="racun">
                <option value="0" selected>Новчаник</option>
    HTML;
    foreach ($naziviRacuna as $racun) {
        if ($transakcija["idRacuna"] == $racun["idRacuna"]) {
            echo <<<HTML
                <option value="$racun[idRacuna]" selected>
            HTML;
            echo $racun["nazivBanke"];
            echo <<<HTML
                </option>
            HTML;
        } else {
            echo <<<HTML
                <option value="$racun[idRacuna]">
            HTML;
            echo $racun["nazivBanke"];
            echo <<<HTML
                </option>
            HTML;
        }
    }
    echo <<<HTML
            </select>
            </div>
            <div class="login-div">
                <input id="datum" name="datum" type="datetime-local" step=1 required>
            </div>
            <div class="login-div">
                <input placeholder="$transakcija[opis]" value="$transakcija[opis]" name="opis">
            </div> <br>
            <div class="login-button-div">
                <button type="submit" name="submit">Потврди</button>
            </div>
        </form>
        HTML;
}
