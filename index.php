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

        /* === Organigrama === */
        #organigrama ul {
            list-style: none;
            padding-left: 1.5rem;
            border-left: 2px solid #ddd;
            margin-left: 1rem;
        }

        #organigrama li {
            margin: 0.5rem 0;
            position: relative;
        }

        #organigrama li::before {
            content: "";
            position: absolute;
            left: -1.5rem;
            top: 0.9rem;
            width: 1.5rem;
            height: 2px;
            background: #ddd;
        }

        .org-nodo {
            background: linear-gradient(135deg, #4facfe 0%, #f093fb 100%);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
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
 <div>
        <!-- aca va el video o carrusel de imagenes -->
        <div class="video-container">
            <video controls autoplay muted loop>
                <source src="./videos/intro.mp4" type="video/mp4">
                Tu navegador no soporta el video.
            </video>
</div>

<div class="main-container">
    <aside>
        <nav>
            <ul>
                <li><a href="#Eventos">Eventos</a></li>
                <li><a href="#Actividades">Actividades</a></li>
                <li><a href="#Comunicados">Comunicados</a></li>
                <li><a href="#modal-contacto">Contacto</a></li>
                <li><a href="#modal-autoridades">Autoridades</a></li>
                <li><a href="./pages/login.html">Iniciar sesión</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <?php
        // Función para renderizar publicaciones por categoría
        function mostrarPublicaciones($pdo, $categoria, $tituloSeccion) {
            $stmt = $pdo->prepare("SELECT * FROM publicaciones WHERE id_categoria = ? ORDER BY fecha_actividad DESC");
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
        mostrarPublicaciones($pdo, '3', 'Actividades');
        mostrarPublicaciones($pdo, '2', 'Comunicados');
        
        ?>
</main>
</div>

<!-- Modal para mostrar las autoridades -->
<div id="modal-autoridades" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Autoridades del Centro</h2>
        <div id="organigrama"></div>
    </div>
</div>

<!-- Modal de contacto -->
<div id="modal-contacto" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
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
    </div>
</div>

<footer>

    <div class="social-media">
        <a href="#" target="_blank" aria-label="Facebook">
            <img src="img/facebook-icon.png" alt="Facebook">
        </a>
        <a href="https://www.instagram.com/col.sec.barriovueltaombu_csvo" target="_blank" aria-label="Instagram">
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
    const msgModal = document.getElementById("modal-msg");
    const autoridadesModal = document.getElementById("modal-autoridades");
    const autoridadesLink = document.querySelector("a[href='#modal-autoridades']");
    const contactoModal = document.getElementById("modal-contacto");
    const contactoLink = document.querySelector("a[href='#modal-contacto']");
    const organigramaContainer = document.getElementById("organigrama");

    function crearNodo(persona) {
        const li = document.createElement('li');
        const nodo = document.createElement('div');
        nodo.className = 'org-nodo';
        if (persona.cargo && persona.nombre) {
            nodo.textContent = `${persona.cargo}: ${persona.nombre}`;
        } else if (persona.cargo) {
            nodo.textContent = persona.cargo;
        } else {
            nodo.textContent = persona.nombre;
        }
        li.appendChild(nodo);

        const hijos = persona.subordinados || persona.miembros;
        if (hijos && hijos.length) {
            const ul = document.createElement('ul');
            hijos.forEach(hijo => ul.appendChild(crearNodo(hijo)));
            li.appendChild(ul);
        }
        return li;
    }

    function cargarAutoridades() {
        fetch('./assets/autoridades.json')
            .then(res => res.json())
            .then(data => {
                organigramaContainer.innerHTML = '';
                const ul = document.createElement('ul');
                data.autoridades.forEach(a => ul.appendChild(crearNodo(a)));
                organigramaContainer.appendChild(ul);
            })
            .catch(() => {
                organigramaContainer.textContent = 'No se pudo cargar el organigrama.';
            });
    }

    // Abrir modal de autoridades
    if (autoridadesLink && autoridadesModal) {
        autoridadesLink.addEventListener('click', (e) => {
            e.preventDefault();
            autoridadesModal.style.display = 'flex';
            cargarAutoridades();
        });
    }

    // Abrir modal de contacto
    if (contactoLink && contactoModal) {
        contactoLink.addEventListener('click', (e) => {
            e.preventDefault();
            contactoModal.style.display = 'flex';
        });
    }

    function closeModal(modal) {
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Cerrar modal de mensaje si existe
    if (msgModal) {
        const closeBtn = msgModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                closeModal(msgModal);
                const url = new URL(window.location);
                url.searchParams.delete('msg');
                history.replaceState(null, '', url);
            });
        }
    }

    // Cerrar modal de autoridades
    if (autoridadesModal) {
        const closeBtn = autoridadesModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => closeModal(autoridadesModal));
        }
    }

    // Cerrar modal de contacto
    if (contactoModal) {
        const closeBtn = contactoModal.querySelector('.close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => closeModal(contactoModal));
        }
    }

    window.addEventListener('click', (e) => {
        if (e.target === msgModal) {
            closeModal(msgModal);
            const url = new URL(window.location);
            url.searchParams.delete('msg');
            history.replaceState(null, '', url);
        } else if (e.target === autoridadesModal) {
            closeModal(autoridadesModal);
        } else if (e.target === contactoModal) {
            closeModal(contactoModal);
        }
    });
});
</script>
</body>
</html>
