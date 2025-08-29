<?php 

# Informacije o bazi podataka
$type       = "mysql";
$server     = "localhost";
$db         = "chrono_shop";
$port       = "8888";
$charset    = "utf8mb4";

$username   = "root";
$password   = "root";

# PDO konfiguracija
$options    = [
    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE    => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES      => false
];

# DSN 
$dsn        = "$type:host=$server;dbname=$db;port=$port;charset=$charset";

# Konekcija sa bazom podataka
try {
    
    $pdo    = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e)
{

    throw new PDOException($e->getMessage(), $e->getCode());

}