<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $id_categoria = (int) $_POST['id_categoria'];
    $id_usuario = $_SESSION['usuario_id']; // o el nombre de tu campo de sesión

    // Manejo de imagen
    $nombreImagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = time() . '_' . basename($_FILES['imagen']['name']);
        $rutaDestino = '../uploads/' . $nombreImagen;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            die("Error al guardar la imagen.");
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO publicaciones (titulo, contenido, imagen, id_usuario, id_categoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $contenido, $nombreImagen, $id_usuario, $id_categoria]);
        header("Location: dashboard.php?mensaje=publicacion_creada");
        exit();
    } catch (PDOException $e) {
        die("Error al guardar publicación: " . $e->getMessage());
    }
} else {
    header("Location: crear_publicacion.php");
    exit();
}
