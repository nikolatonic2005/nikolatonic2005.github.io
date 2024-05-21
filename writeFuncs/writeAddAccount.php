<?php
function ispisi()
{
    echo <<<HTML
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a href="main.php">Преглед</a>
            <a href="transactions.php">Трансакције</a>
            <a id="accounts" href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
            <a href="manageAccount.php">Управљање налогом</a>
        </div>
    </header>
    <main> 
        <form method="post">
            <div class="welcome-div">Додај рачун</div> <br>
            <div class="login-div">
                <input placeholder="Назив рачуна" name="naziv" required/>
            </div>
            <div class="login-div">
                <input placeholder="Стање на рачуну" name="stanje" type="number" step="0.01" required/>
            </div> <br>
            <div class="login-button-div">
                <button type="submit" name="submit">Потврди</button>
            </div>
        </form>
    HTML;
}
