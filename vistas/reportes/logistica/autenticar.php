<?php
require 'config.php';

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM usuarioslogistica WHERE usuario = :usuario AND password = :password";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario' => $usuario, 'password' => $password]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['usuario'] = $usuario;
    header("Location: bienvenida.php");
} else {
    header("Location: login.php?error=1");
}
