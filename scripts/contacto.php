// scripts/contacto.php
<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if ($nombre === '' || $email === '' || $mensaje === '') {
        header('Location: ../index.php?msg=' . urlencode('Por favor completá todos los campos.'));
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../index.php?msg=' . urlencode('Email inválido.'));
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO mensajes_contacto (nombre, email, mensaje)
            VALUES (:nombre, :email, :mensaje)
        ");
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':mensaje' => $mensaje
        ]);

        header('Location: ../index.php?msg=' . urlencode('¡Gracias por tu mensaje!'));
        exit;
    } catch (PDOException $e) {
        header('Location: ../index.php?msg=' . urlencode('Error al guardar el mensaje.'));
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}
