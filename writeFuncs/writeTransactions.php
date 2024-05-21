<?php
function ispisi($naziviRacuna, $transakcije, $br)
{
    echo <<<HTML
<header>
    <div class="naslov">
        <a href="main.php">ToniTracker</a>
    </div>
    <div class="nav">
        <a href="main.php">Преглед</a>
        <a id="transactions" href="transactions.php">Трансакције</a>
        <a href="accounts.php">Рачуни</a>
        <a href="logout.php">Одјави се</a>
        <a href="manageAccount.php">Управљање налогом</a>
    </div>
</header>
<main>
<table>
    <thead>
        <th>Износ трансакције</th>
        <th>Назив рачуна</th>
        <th>Датум трансакције</th>
        <th>Опис</th>
    </thead>
HTML;
    foreach ($transakcije as $transakcija) {
        $dan = substr($transakcija["datum"], 8, 2);
        $mesec = substr($transakcija["datum"], 5, 2);
        $godina = substr($transakcija["datum"], 0, 4);
        $sat = substr($transakcija["datum"], 11, 2);
        $minut = substr($transakcija["datum"], 14, 2);
        $sekund = substr($transakcija["datum"], 17, 2);

        $datum =
            $dan .
            ". " .
            $mesec .
            ". " .
            $godina .
            ". " .
            $sat .
            ":" .
            $minut .
            ":" .
            $sekund;
        foreach ($naziviRacuna as $nazivRacuna) {
            if ($transakcija["idRacuna"] == 0) {
                echo <<<HTML
<tr>
    <td>
HTML;
                echo "RSD " .
                    number_format($transakcija["promenaStanja"], 2, ",", ".");
                echo <<<HTML
    </td>
    <td>Новчаник</td>
    <td>$datum</td>
    <td>$transakcija[opis]</td>
    <td>
        <form method="post" name="change">
            <button id="change" value=$transakcija[idTransakcije] name="change" type="submit"><img src="images/pencil.png"></button>
        </form>
    </td>
    <td>
        <form method="post" name="delete">
            <button id="delete" value=$transakcija[idTransakcije] name="delete" type="submit"><img src="images/trash.png"></button>
        </form>
    </td>
</tr>
HTML;
                $br++;
                break;
            }
            if ($transakcija["idRacuna"] == $nazivRacuna["idRacuna"]) {
                echo <<<HTML
<tr>
<td>
HTML;
                echo "RSD " .
                    number_format($transakcija["promenaStanja"], 2, ",", ".");
                echo <<<HTML
    </td>
    <td>$nazivRacuna[nazivBanke]</td>
    <td>$datum</td>
    <td>$transakcija[opis]</td>
    <td>
        <form method="post" name="change">
            <button id="change" value=$transakcija[idTransakcije] name="change" type="submit"><img src="images/pencil.png"></button>
        </form>
    </td>
    <td>
        <form method="post" name="delete">
            <button id="delete" value=$transakcija[idTransakcije] name="delete" type="submit"><img src="images/trash.png"></button>
        </form>
    </td>
</tr>
HTML;
                $br++;
            }
        }
    }

    echo <<<HTML
    
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <a id="new" href="addTransaction.php"><img src="images/new.png"></a>
        </td>
    </tr>
HTML;
}
