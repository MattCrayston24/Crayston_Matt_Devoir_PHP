<?php
$config = require '../.env.php';

$pdo = new PDO(
    'mysql:host=' . $config['DB_HOST'] . ';dbname=' . $config['DB_NAME'], 
    $config['DB_USER'], 
    $config['DB_PASS']
);

if ($pdo->errorCode() !== null) {
    $errorInfo = $pdo->errorInfo();
    die("Erreur de connexion à la base de données : " . $errorInfo[2]);
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>