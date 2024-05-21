<?php
session_start();
include 'db.php';
$konekcija = connectDB();
$delete = $konekcija -> prepare('DELETE FROM transakcija WHERE idKorisnika = :id');
$delete -> execute(["id" => $_SESSION["id"]]);
$delete = $konekcija -> prepare('DELETE FROM racun WHERE idKorisnika = :id');
$delete -> execute(["id" => $_SESSION["id"]]);
$delete = $konekcija -> prepare('DELETE FROM korisnik WHERE id = :id');
$delete -> execute(["id" => $_SESSION["id"]]);
session_destroy();
echo <<<html
    <script>
        window.location = "begin.php";
    </script>
    html;
