<?php
function connectDB()
{
    $databaseFile = 'stednja.db';
    try {
        $connection = new PDO("sqlite:$databaseFile");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
