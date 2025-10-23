<?php

$dsn = 'mysql:host=localhost;dbname=rifaphp2025';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Falha na conexão: ' . $e->getMessage();
}
?>
