<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int) $_GET['id'];

// Buscar publicación para borrar imagen si corresponde
$stmt = $pdo->prepare("SELECT imagen FROM publicaciones WHERE id = ?");
$stmt->execute([$id]);
$pub = $stmt->fetch();

if ($pub && $pub['imagen']) {
    $rutaImagen = '../uploads/' . $pub['imagen'];
    if (file_exists($rutaImagen)) {
        unlink($rutaImagen); // Elimina la imagen del servidor
    }
}

try {
    $stmt = $pdo->prepare("DELETE FROM publicaciones WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: dashboard.php?mensaje=publicacion_eliminada");
    exit();
} catch (PDOException $e) {
    die("Error al eliminar publicación: " . $e->getMessage());
}
