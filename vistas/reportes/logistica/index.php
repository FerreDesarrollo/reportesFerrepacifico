<?php
include 'config.php';

// Si el usuario ya está logueado, redirige a bienvenida.php
if (isset($_SESSION['usuario'])) {
    header("Location: bienvenida.php");
    exit;
}

// Si no ha iniciado sesión, redirige al login
header("Location: login.php");
exit;
