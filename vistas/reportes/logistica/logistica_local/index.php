<?php
include 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Si el usuario ya está logueado, redirige a bienvenida.php
if (isset($_SESSION['usuario'])) {
    header("Location: sincronizar.php");
    exit;
}

// Si no ha iniciado sesión, redirige al login
header("Location: login.php");
exit;
