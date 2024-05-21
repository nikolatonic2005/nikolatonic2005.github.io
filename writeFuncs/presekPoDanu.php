<?php
$konekcija = connectDB();

$danasZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now'), 1, 10)");
$danasZaradaQuery->execute(["id" => $_SESSION["id"]]);
$danasZarada = $danasZaradaQuery->fetchColumn();

$danasPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now'), 1, 10)");
$danasPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$danasPotrosnja = $danasPotrosnjaQuery->fetchColumn();

$subotaZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-1 day'), 1, 10)");
$subotaZaradaQuery->execute(["id" => $_SESSION["id"]]);
$subotaZarada = $subotaZaradaQuery->fetchColumn();

$subotaPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-1 day'), 1, 10)");
$subotaPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$subotaPotrosnja = $subotaPotrosnjaQuery->fetchColumn();

$petakZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-2 day'), 1, 10)");
$petakZaradaQuery->execute(["id" => $_SESSION["id"]]);
$petakZarada = $petakZaradaQuery->fetchColumn();

$petakPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-2 day'), 1, 10)");
$petakPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$petakPotrosnja = $petakPotrosnjaQuery->fetchColumn();

$cetvrtakZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-3 day'), 1, 10)");
$cetvrtakZaradaQuery->execute(["id" => $_SESSION["id"]]);
$cetvrtakZarada = $cetvrtakZaradaQuery->fetchColumn();

$cetvrtakPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-3 day'), 1, 10)");
$cetvrtakPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$cetvrtakPotrosnja = $cetvrtakPotrosnjaQuery->fetchColumn();

$sredaZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-4 day'), 1, 10)");
$sredaZaradaQuery->execute(["id" => $_SESSION["id"]]);
$sredaZarada = $sredaZaradaQuery->fetchColumn();

$sredaPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-4 day'), 1, 10)");
$sredaPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$sredaPotrosnja = $sredaPotrosnjaQuery->fetchColumn();

$utorakZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-5 day'), 1, 10)");
$utorakZaradaQuery->execute(["id" => $_SESSION["id"]]);
$utorakZarada = $utorakZaradaQuery->fetchColumn();

$utorakPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-5 day'), 1, 10)");
$utorakPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$utorakPotrosnja = $utorakPotrosnjaQuery->fetchColumn();

$ponedeljakZaradaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja > 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-6 day'), 1, 10)");
$ponedeljakZaradaQuery->execute(["id" => $_SESSION["id"]]);
$ponedeljakZarada = $ponedeljakZaradaQuery->fetchColumn();

$ponedeljakPotrosnjaQuery = $konekcija->prepare("SELECT SUM(promenaStanja) AS zarada FROM transakcija WHERE
    idKorisnika = :id AND
    promenaStanja < 0 AND
    SUBSTR(datum, 1, 10) = SUBSTR(DATE('now','-6 day'), 1, 10)");
$ponedeljakPotrosnjaQuery->execute(["id" => $_SESSION["id"]]);
$ponedeljakPotrosnja = $ponedeljakPotrosnjaQuery->fetchColumn();
?>
