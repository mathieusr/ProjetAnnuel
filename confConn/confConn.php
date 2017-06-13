<?php
try {
    $pdo = new PDO("sqlsrv:server = tcp:projetannuel.database.windows.net,1433; Database = LoupDeParis", "mathieu", "projetannuel1A2");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
