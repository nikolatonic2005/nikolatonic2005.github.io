<?php
session_start();
include 'db.php';
include 'writeFuncs/presekPoDanu.php';
$konekcija = connectDB();
if ($_SESSION["id"] == '') {
    echo <<<html
        <script>
            window.location = "begin.php"
        </script>
        html;
}
$novcanikquery = $konekcija->prepare('SELECT stanje FROM korisnik WHERE id = :id');
$novcanikquery->execute(['id' => $_SESSION["id"]]);
$novcanik = $novcanikquery->fetchColumn();

$racuniquery = $konekcija->prepare('SELECT * FROM racun WHERE idKorisnika = :id');
$racuniquery->execute(['id' => $_SESSION["id"]]);
$racuni = $racuniquery->fetchAll();

$sumaquery = $konekcija->prepare('SELECT SUM(stanje) FROM racun WHERE idKorisnika = :id');
$sumaquery->execute(['id' => $_SESSION["id"]]);
$suma = $novcanik + ($sumaquery->fetchColumn());

$zaradaOvogMesecaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 7) = SUBSTR(DATE('now'), 1, 7)");
$zaradaOvogMesecaQuery->execute(["id" => $_SESSION["id"]]);
$zaradaOvogMeseca = $zaradaOvogMesecaQuery->fetchColumn();

$potrosnjaOvogMesecaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 7) = SUBSTR(DATE('now'), 1, 7)");
$potrosnjaOvogMesecaQuery->execute(["id" => $_SESSION["id"]]);
$potrosnjaOvogMeseca = $potrosnjaOvogMesecaQuery->fetchColumn();


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
    <header>
        <div class="naslov">
            <a href="main.php">ToniTracker</a>
        </div>
        <div class="nav">
            <a id="pregled" href="main.php">Преглед</a>
            <a href="transactions.php">Трансакције</a>
            <a href="accounts.php">Рачуни</a>
            <a href="logout.php">Одјави се</a>
            <a href="manageAccount.php">Управљање налогом</a>
        </div>
    </header>
    <?php
    echo '<div class="greeting">Здраво, ' . $_SESSION["name"] . '.</div>';
    ?>
    <div class="main">
        <div class="pregled" style="cursor: pointer;" onclick="window.location='accounts.php';">
            <h2>Стање</h2>
            <br>
            <div class="racun">
                <div>Новчаник:</div>
                <div>
                    <?php
                    echo "RSD " . number_format($novcanik, 2, ",", ".");
                    ?>
                </div>
            </div>
            <?php
            foreach ($racuni as $racun) {
                echo <<<HTML
                        <div class="racun">
                            <div>$racun[nazivBanke]:</div>
                            <div>
                    HTML;
                echo "RSD " . number_format($racun["stanje"], 2, ",", ".");
                echo <<<HTML
                            </div>
                        </div>
                    HTML;
            }
            ?>

            <div class="racun">
                <div></div>
                <div>——————</div>
            </div>
            <div class="racun">
                <div></div>
                <div>
                    <?php
                    echo "RSD " . number_format($suma, 2, ",", ".");
                    ?>
                </div>
            </div>
        </div>
        <div class="pregled">
            <h2>Овај месец</h2><br>
            <div class="presek">
                <div style="height:6rem; width:6rem">
                    <canvas id="presek"></canvas>
                    <script type="text/javascript" src="/chart.umd.js"></script>
                    <script>
                        (async function() {
                            var zarada = '<?php echo $zaradaOvogMeseca; ?>';
                            var potrosnja = '<?php echo $potrosnjaOvogMeseca; ?>';
                            var x = ["Зарађено", "Потрошено"];
                            var y = [zarada, potrosnja];
                            new Chart(
                                document.getElementById('presek'), {
                                    type: 'doughnut',
                                    data: {
                                        labels: x,
                                        datasets: [{
                                            label: 'Овај месец',
                                            data: y
                                        }]
                                    },
                                    options: {
                                        plugins: {
                                            legend: {
                                                display: false
                                            },
                                            tooltip: {
                                                enabled: false
                                            },
                                        }
                                    }
                                }
                            );
                        })();
                    </script>
                </div>
                <div class="opis">
                    <a style="color: #36a2eb">Зарађено:</a>
                    <?php
                    echo "RSD " . number_format($zaradaOvogMeseca, 2, ",", ".");
                    ?><br>
                    <a style="color: #ff6384">Потрошено:</a>
                    <?php
                    echo "RSD " . number_format($potrosnjaOvogMeseca * (-1), 2, ",", ".");
                    ?>
                </div>
            </div>
        </div>
        <div class="pregled">
            <h2>Протеклих 7 дана</h2><br>
            <div>
                <canvas id="presek1"></canvas>
                <script type="text/javascript" src="/chart.umd.js"></script>
                <script>
                    zarada7 = '<?php echo $danasZarada; ?>';
                    potrosnja7 = '<?php echo $danasPotrosnja; ?>' * (-1);
                    zarada6 = '<?php echo $subotaZarada; ?>';
                    potrosnja6 = '<?php echo $subotaPotrosnja; ?>' * (-1);
                    zarada5 = '<?php echo $petakZarada; ?>';
                    potrosnja5 = '<?php echo $petakPotrosnja; ?>' * (-1);
                    zarada4 = '<?php echo $cetvrtakZarada; ?>';
                    potrosnja4 = '<?php echo $cetvrtakPotrosnja; ?>' * (-1);
                    zarada3 = '<?php echo $sredaZarada; ?>';
                    potrosnja3 = '<?php echo $sredaPotrosnja; ?>' * (-1);
                    zarada2 = '<?php echo $utorakZarada; ?>';
                    potrosnja2 = '<?php echo $utorakPotrosnja; ?>' * (-1);
                    zarada1 = '<?php echo $ponedeljakZarada; ?>';
                    potrosnja1 = '<?php echo $ponedeljakPotrosnja; ?>' * (-1);
                    x1 = [];
                    for (i = 0; i < 7; i++) {
                        temp = new Date();
                        temp.setDate(temp.getDate() - i);
                        x1[i] = temp.getDate() + "." + (temp.getMonth() + 1);
                    }
                    x = x1.reverse();
                    y1 = [zarada1, zarada2, zarada3, zarada4, zarada5, zarada6, zarada7];
                    y2 = [potrosnja1, potrosnja2, potrosnja3, potrosnja4, potrosnja5, potrosnja6, potrosnja7];
                    (async function() {
                        new Chart(
                            document.getElementById('presek1'), {
                                type: 'bar',
                                data: {
                                    labels: x,
                                    datasets: [{
                                            data: y1
                                        },
                                        {
                                            data: y2
                                        }
                                    ]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                    }
                                }
                            }
                        );
                    })();
                </script>
            </div>
        </div>
    </div>

</body>

</html>