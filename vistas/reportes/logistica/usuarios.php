<?php
require_once 'config.php'; // contiene $pdo y session_start()

class Usuarios {

    public function loginUser($usuario, $password) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['iduser'] = $user['id'];
            return true;
        } else {
            return false;
        }
    }

    public function registroUsuario($usuario, $passwordPlano) {
        global $pdo;

        $passwordHash = password_hash($passwordPlano, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
        return $stmt->execute([$usuario, $passwordHash]);
    }

    public function obtenDatosUsuario($idusuario) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT id, usuario FROM usuarios WHERE id = ?");
        $stmt->execute([$idusuario]);
        return $stmt->fetch();
    }
}
?>
