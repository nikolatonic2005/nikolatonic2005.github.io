<?php
function ispisi($racuni)
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
<table>
    <thead>
        <th>Бр.</th>
        <th>Назив рачуна</th>
        <th>Стање на рачуну</th>
        <th></th>
        <th></th>
    </thead>
HTML;
    $br = 1;
    foreach ($racuni as $racun) {
        echo <<<HTML
    <tr>
        <td>$br</td>
        <td>$racun[nazivBanke]</td>
        <td>
    HTML;
        echo "RSD " . number_format($racun["stanje"], 2, ",", ".");
        echo <<<HTML
        </td>
        <td>
            <form method="post" name="change">
                <button id="change" value=$racun[idRacuna] name="change" type="submit"><img src="images/pencil.png"></button>
            </form>
        </td>
        <td>
            <form method="post" name="delete">
                <button id="delete" value=$racun[idRacuna] name="delete" type="submit"><img src="images/trash.png"></button>
            </form>
        </td>
    </tr>
    HTML;
        $br++;
    }
    echo <<<HTML
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <a id="new" href="addAccount.php"><img src="images/new.png"></a>
        </td>
    </tr>
    <tr>
    </tr>
    </table>
</main>
HTML;
}
