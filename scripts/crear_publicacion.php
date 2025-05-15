<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

// Obtener las categorías para el selector
try {
    $stmt = $pdo->query("SELECT * FROM categorias ORDER BY nombre_categoria ASC");
    $categorias = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al cargar categorías: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Publicación</title>
    <link rel="stylesheet" href="../estilos/style-guide-centro-estudiantes.css">
    <link rel="stylesheet" href="../estilos/estilosindex.css">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    
</head>
<body>
<div class="main-container">
    <div class="formulario">
    <h1>Crear nueva publicación</h1>
    <form action="procesar_crear_publicacion.php"  method="post" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required><br>

        <label for="contenido">Contenido:</label><br>
        <textarea name="contenido" id="contenido" rows="6" required></textarea><br>

        <label for="categoria">Categoría:</label>
        <select name="id_categoria" id="categoria" required>
            <option value="">-- Seleccionar --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nombre_categoria']) ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="imagen">Imagen (opcional):</label>
        <input type="file" name="imagen" class="boton-secundario" id="imagen" accept="image/*"><br>

        <button type="submit" class="boton-principal">Publicar</button>
    </form>

    <p><a href="dashboard.php">← Volver al panel</a></p>
    </div>
</div>

</body>
</html>
