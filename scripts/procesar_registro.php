<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre_usuario, clave, correo) VALUES (:nombre, :clave, :correo)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':nombre' => $nombre_usuario,
            ':clave' => $clave,
            ':correo' => $correo
        ]);
        echo "Usuario registrado correctamente. <a href='login.php'>Iniciar sesión</a>";
    } catch (PDOException $e) {
        echo "Error al registrar usuario: " . $e->getMessage();
    }
}
?>
