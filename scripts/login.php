<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $clave = $_POST['clave'];

    $sql = "SELECT id, clave FROM usuarios WHERE nombre_usuario = :nombre";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre_usuario);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre_usuario'] = $nombre_usuario;
        header("Location: dashboard.php");
        exit;
    } else {
        //redirect to login page with error
        header("Location: ../index.php?error=1");
    }
}
?>
