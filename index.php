<?php include './scripts/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Estudiantes</title>
    <link rel="stylesheet" href="./estilos/style-guide-centro-estudiantes.css">
    <link rel="stylesheet" href="./estilos/estilosindex.css">
    <link rel="shortcut icon" href="./img/favicon/favicon.ico" type="image/x-icon">
    <style>
        .modal {
            display: flex;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            position: relative;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .modal .close {
            position: absolute;
            top: 0.5rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['msg'])): ?>
<div id="modal-msg" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p><?= htmlspecialchars($_GET['msg']) ?></p>
    </div>
</div>
<?php endif; ?>

<header>
    <div class="headerimglogo">
        <img src="./img/insigniaESVO-removebg-preview.png" alt="Logo de la escuela ESVO">
    </div>
    <div class="headertitulo">
        <h1>Colegio Secundario Barrio Vuelta al Ombú<br> Centro de Estudiantes</h1>
    </div>
    <div class="headerimgcentro">
        <img src="./img/logoCentro.jpeg" alt="Logo del centro de estudiantes">
    </div>
</header>

<div class="main-container">
    <aside>
        <nav>
            <ul>
                <li><a href="#Eventos">Eventos</a></li>
                <li><a href="#Comunicados">Comunicados</a></li>
                <li><a href="#En acción">En acción</a></li>
                <li><a href="#contacto-form">Contacto</a></li>
                <li><a href="./pages/login.html">Iniciar sesión</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <?php
        // Función para renderizar publicaciones por categoría
        function mostrarPublicaciones($pdo, $categoria, $tituloSeccion) {
            $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE id_categoria = ?");
            $stmt->execute([$categoria]);
            $publicaciones = $stmt->fetchAll();

            echo "<section id=\"$tituloSeccion\">";
            echo "<h2>$tituloSeccion</h2>";
            echo "<div class=\"card-container\">";

            if ($publicaciones) {
                foreach ($publicaciones as $pub) {
                    echo "<article class=\"card\">";
                    echo "<h3>" . htmlspecialchars($pub['titulo']) . "</h3>";
                    if (!empty($pub['imagen'])) {
                        echo "<img src=\"./uploads/" . htmlspecialchars($pub['imagen']) . "\" alt=\"Imagen\">";
                    }
                    echo "<p>" . htmlspecialchars($pub['contenido']) . "</p>";
                    echo "</article>";
                }
            } else {
                echo "<p>No hay publicaciones en esta sección.</p>";
            }

            echo "</div></section>";
        }

        // Mostrar cada sección
        mostrarPublicaciones($pdo, '1', 'Eventos');
        mostrarPublicaciones($pdo, '2', 'Comunicados');
        mostrarPublicaciones($pdo, '3', 'En acción');
        ?>
    </main>
</div>

<footer>
    <form action="scripts/contacto.php" method="post" id="contacto-form">
        <h2>Déjanos tu mensaje</h2>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" required></textarea>

        <button type="submit">Enviar</button>
    </form>

    <div class="social-media">
        <a href="#" target="_blank" aria-label="Facebook">
            <img src="img/facebook-icon.png" alt="Facebook">
        </a>
        <a href="./img/instagram-icon.png" target="_blank" aria-label="Instagram">
            <img src="img/instagram.svg" alt="Instagram">
        </a>
        <a href="#" target="_blank" aria-label="Twitter">
            <img src="img/twitter-icon.png" alt="Twitter">
        </a>
    </div>

    <div class="copyright">
        <p>&copy; 2025 Centro de Estudiantes ESVO. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modal-msg");
    const closeBtn = document.querySelector(".modal .close");

    if (modal && closeBtn) {
        closeBtn.onclick = () => {
            modal.style.display = "none";
            const url = new URL(window.location);
            url.searchParams.delete("msg");
            history.replaceState(null, "", url); // Limpiar la URL
        };

        window.onclick = (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
                const url = new URL(window.location);
                url.searchParams.delete("msg");
                history.replaceState(null, "", url);
            }
        };
    }
});
</script>
</body>
</html>
