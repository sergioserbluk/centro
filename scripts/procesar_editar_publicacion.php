<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $id_categoria = (int) $_POST['id_categoria'];

    // Obtener publicación actual para verificar imagen previa
    $stmt = $pdo->prepare("SELECT imagen FROM publicaciones WHERE id = ?");
    $stmt->execute([$id]);
    $publicacion = $stmt->fetch();

    if (!$publicacion) {
        die("Publicación no encontrada.");
    }

    $nombreImagen = $publicacion['imagen'];

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nuevoNombre = time() . '_' . basename($_FILES['imagen']['name']);
        $rutaDestino = '../uploads/' . $nuevoNombre;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            $nombreImagen = $nuevoNombre;
        } else {
            die("Error al subir la nueva imagen.");
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE publicaciones SET titulo = ?, contenido = ?, imagen = ?, id_categoria = ? WHERE id = ?");
        $stmt->execute([$titulo, $contenido, $nombreImagen, $id_categoria, $id]);

        header("Location: dashboard.php?mensaje=publicacion_editada");
        exit();
    } catch (PDOException $e) {
        die("Error al actualizar publicación: " . $e->getMessage());
    }
}
