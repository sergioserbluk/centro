<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id_publicacion = (int) $_GET['id'];

// Obtener publicación
try {
    $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE id = ?");
    $stmt->execute([$id_publicacion]);
    $publicacion = $stmt->fetch();

    if (!$publicacion) {
        die("Publicación no encontrada.");
    }

    // Obtener categorías
    $stmtCat = $pdo->query("SELECT * FROM categorias ORDER BY nombre_categoria ASC");
    $categorias = $stmtCat->fetchAll();
} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../estilos/style-guide-centro-estudiantes.css">
    <link rel="stylesheet" href="../estilos/estilosindex.css">
    <link rel="stylesheet" href="../estilos/estilos.css">
    <title>Editar Publicación</title>
</head>
<body>
    <header>
        <h1>Centro de Estudiantes</h1>
        </header>
       <div class="main-container">
           
        <aside>   
        <nav>
            <ul>
                <li><a href="dashboard.php">Inicio</a></li>
                <li><a href="crear_publicacion.php">Crear Publicación</a></li>
                <li><a href="editar_publicacion.php?id=<?= $id_publicacion ?>">Editar Publicación</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </nav>
        </aside>
    
        <main>
      
    <h2>Editar publicación</h2>
    <form class="form-editarpublicacion" action="procesar_editar_publicacion.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $publicacion['id'] ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($publicacion['titulo']) ?>" required><br>

        <label for="contenido">Contenido:</label><br>
        <textarea name="contenido" id="contenido" rows="6" required><?= htmlspecialchars($publicacion['contenido']) ?></textarea><br>

        <label for="categoria">Categoría:</label>
        <select name="id_categoria" id="categoria" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $publicacion['id_categoria'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nombre_categoria']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <p>Imagen actual: <?= $publicacion['imagen'] ? $publicacion['imagen'] : 'No hay imagen' ?></p>
        <label for="imagen">Cambiar imagen (opcional):</label>
        <input type="file" name="imagen" id="imagen" accept="image/*"><br>

        <button type="submit">Guardar cambios</button>
    </form>

    <p><a href="dashboard.php">← Volver al panel</a></p>
    </main>
     </div>
</body>
</html>
