<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

// Aquí podés traer las publicaciones de la base
try {
    $stmt = $pdo->query(" SELECT 
            publicaciones.id,
            publicaciones.titulo,
            publicaciones.contenido,
            publicaciones.imagen,
            publicaciones.fecha_publicacion,
            publicaciones.fecha_actividad,
            categorias.nombre_categoria
        FROM publicaciones
        INNER JOIN categorias ON publicaciones.id_categoria = categorias.id
        ORDER BY publicaciones.fecha_publicacion DESC");
    $publicaciones = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener publicaciones: " . $e->getMessage());
}

$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;

// Traer mensajes del formulario de contacto
try {
    $stmt_mensajes = $pdo->query("SELECT m.*, u.nombre_usuario AS respondido_por FROM mensajes_contacto m LEFT JOIN usuarios u ON m.id_usuario_respuesta = u.id ORDER BY m.fecha_envio DESC");
    $mensajes_contacto = $stmt_mensajes->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener mensajes: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../estilos/style-guide-centro-estudiantes.css">
    <link rel="stylesheet" href="../estilos/estilosindex.css">
    <link rel="shortcut icon" href="../img/favicon/favicon.ico" type="image/x-icon">
    <title>Panel de control</title>
    <link rel="stylesheet" href="estilos/estilos.css">
    <style>
        /* Estilo para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-contenido {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .modal-contenido button {
            margin-top: 15px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-contenido button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<?php if ($mensaje): ?>
    <div id="miModal" class="modal">
        <div class="modal-contenido">
            <p><?= htmlspecialchars($mensaje) ?></p>
            <button onclick="cerrarModal()">Aceptar</button>
        </div>
    </div>

    <script>
        document.getElementById('miModal').style.display = 'block';
        function cerrarModal() {
            document.getElementById('miModal').style.display = 'none';
            history.replaceState(null, '', location.pathname); // Limpia el ?mensaje
        }
    </script>
<?php endif; ?>
<header>

<h1>Bienvenido al Panel de Control</h1>
<p>Usuario: <?= htmlspecialchars($_SESSION['nombre_usuario']) ?> <br> <a href="logout.php">Cerrar sesión</a></p>

<h1>Centro de Estudiantes</h1>
</header>
<div class="main-container">

    <main>
    <div class="ochentaporcent">
        
        <p>Panel de control para gestionar publicaciones y categorías.</p>
    
        <h2>Publicaciones</h2>
        <a href="crear_publicacion.php">+ Nueva publicación</a>

        <table border="1">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Fecha de publicación</th>
                    <th>Fecha de actividad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($publicaciones as $pub): ?>
                <tr>
                    <td><?= htmlspecialchars($pub['titulo']) ?></td>
                    <td><?= htmlspecialchars($pub['nombre_categoria']) ?></td>
                    <td><?= htmlspecialchars($pub['fecha_publicacion']) ?></td>
                    <td><?= htmlspecialchars($pub['fecha_actividad']) ?></td>
                    <td>
                        <a href="editar_publicacion.php?id=<?= $pub['id'] ?>">Editar</a> |
                        <a href="eliminar_publicacion.php?id=<?= $pub['id'] ?>" onclick="return confirm('¿Seguro que querés eliminar esta publicación?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Mensajes de Contacto</h2>
    <table border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Mensaje</th>
            <th>Fecha</th>
            <th>Respuesta</th>
            <th>Respondido por</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mensajes_contacto as $msg): ?>
        <tr>
            <td><?= htmlspecialchars($msg['nombre']) ?></td>
            <td><?= htmlspecialchars($msg['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($msg['mensaje'])) ?></td>
            <td><?= $msg['fecha_envio'] ?></td>
            <td><?= $msg['respuesta'] ? nl2br(htmlspecialchars($msg['respuesta'])) : 'Sin responder' ?></td>
            <td><?= htmlspecialchars($msg['respondido_por'] ?? '') ?></td>
            <td>
                <a href="responder_mensaje.php?id=<?= $msg['id'] ?>">Responder</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
            </div>
    </main>
    </div>
    <footer>
        <p>&copy; 2025 Centro de Estudiantes. Todos los derechos reservados.</p>
        <div class="social-media">
            <a href="#" target="_blank" aria-label="Facebook">
                <img src="../img/facebook-icon.png" alt="Facebook">
            </a>
            <a href="#" target="_blank" aria-label="Instagram">
                <img src="../img/instagram-icon.png" alt="Instagram">
            </a>
            <a href="#" target="_blank" aria-label="Twitter">
                <img src="../img/twitter-icon.png" alt="Twitter">
            </a>
        </div>
        </footer>

</body>
</html>
