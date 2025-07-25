<?php
$host = 'ferrepacifico.com.mx';
$db   = 'ferrepac_reportes';
$user = 'ferrepac_reporte';
$pass = '0t+4KVH]1Fhi';
$port = '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}

session_start();
?>
