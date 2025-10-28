# Guía de exposición del proyecto "Conectando al Centro de Estudiantes"

Esta guía resume los objetivos pedagógicos del material **Conectando al Centro de Estudiantes** y vincula cada eje teórico con los archivos del repositorio que lo implementan. Está pensada para que cada grupo pueda explicar qué aprendió, mostrar el código correspondiente y articular la teoría con la práctica durante la exposición.

## Objetivos generales destacados en el PDF

- Facilitar la comunicación entre el Centro de Estudiantes y toda la comunidad educativa mediante una plataforma web participativa.
- Promover el trabajo colaborativo con roles definidos, integrando programación, diseño y bases de datos.
- Presentar un sitio funcional, seguro, accesible y con diseño responsivo listo para una feria académica.

## Mapa de teoría a código por grupo

### Grupo 1 – Seguridad en el acceso

**Teoría trabajada**

- Autenticación con usuario y contraseña y manejo de sesiones activas.
- Cifrado de contraseñas con funciones seguras (`password_hash`, `password_verify`) y nociones de hashing + salting.
- Riesgos de no proteger las zonas administrativas y necesidad de cerrar sesión.

**Archivos para mostrar durante la exposición**

1. `scripts/procesar_registro.php`: crea usuarios nuevos con `password_hash` para evitar contraseñas en texto plano antes de guardarlas en la base.【F:scripts/procesar_registro.php†L1-L22】
2. `scripts/login.php`: valida las credenciales con consultas preparadas y `password_verify`, inicia la sesión y redirige al panel seguro.【F:scripts/login.php†L1-L24】
3. `scripts/validar_sesion.php` y `scripts/logout.php`: controlan el acceso a las páginas internas y cierran la sesión limpiamente.【F:scripts/validar_sesion.php†L1-L9】【F:scripts/logout.php†L1-L6】
4. `scripts/dashboard.php`: ejemplo práctico de página protegida que depende de la sesión activa y muestra los datos administrativos.【F:scripts/dashboard.php†L1-L78】

**Tips para la demo**

- Mostrar el flujo completo: registro (si corresponde), login, navegación por el panel y cierre de sesión.
- Explicar cómo `$_SESSION['nombre_usuario']` actúa como la “caja invisible” mencionada en el PDF para verificar el acceso.
- Resaltar que aun con acceso al servidor, las contraseñas siguen protegidas gracias al hashing.

### Grupo 2 – Datos y conexión con la base

**Teoría trabajada**

- Modelado de datos en MySQL para usuarios, publicaciones y mensajes del formulario.
- Uso de PDO y consultas preparadas para evitar inyecciones SQL.
- Persistencia de publicaciones, imágenes y respuestas desde el panel de control.

**Archivos para mostrar durante la exposición**

1. `scripts/conexion.php`: configura PDO con `ATTR_ERRMODE`, `FETCH_ASSOC` y sin emulación de `prepare`, tal como recomienda la teoría del PDF.【F:scripts/conexion.php†L1-L21】
2. `scripts/contacto.php`: ejemplo de inserción con prepared statements que valida entradas antes de guardar mensajes de la comunidad.【F:scripts/contacto.php†L1-L35】
3. `scripts/procesar_crear_publicacion.php` y `scripts/procesar_editar_publicacion.php`: muestran cómo se persisten publicaciones, se suben imágenes y se controla la categoría seleccionada.【F:scripts/procesar_crear_publicacion.php†L1-L33】【F:scripts/procesar_editar_publicacion.php†L1-L35】
4. `scripts/responder_mensaje.php`: integra base de datos + envío de correo con PHPMailer, y registra quién responde cada mensaje en la tabla correspondiente.【F:scripts/responder_mensaje.php†L1-L83】

**Tips para la demo**

- Preparar una consulta en MySQL (o pantallazo) para mostrar cómo quedan almacenados los registros.
- Destacar que cada acción en el panel corresponde a una consulta SQL preparada (insert/update/delete) que mantiene la integridad de la base.

### Grupo 3 – Diseño y estructura del sitio

**Teoría trabajada**

- Uso de HTML semántico (`<header>`, `<main>`, `<nav>`, `<section>`) para accesibilidad.
- CSS responsivo con Flexbox y media queries para adaptar la interfaz a celulares, tablets y PC.
- Importancia de textos alternativos (`alt`) e iconografía accesible.

**Archivos para mostrar durante la exposición**

1. `index.php`: organiza la página principal con secciones claramente etiquetadas, formulario modal accesible y renderizado dinámico de tarjetas desde la base.【F:index.php†L1-L139】
2. `estilos/estilosindex.css`: concentra el diseño responsivo con flexbox, `flex-wrap` y `@media (max-width: 768px)` para adaptar menús y tarjetas al ancho disponible.【F:estilos/estilosindex.css†L5-L180】【F:estilos/estilosindex.css†L234-L247】
3. `estilos/style-guide-centro-estudiantes.css` y `estilos/banner.css`: definen la paleta, tipografías y animaciones que hacen coherente la identidad visual (mencionarlo y mostrar brevemente la estructura de variables y componentes si hay tiempo).【F:estilos/style-guide-centro-estudiantes.css†L1-L120】

**Tips para la demo**

- Reducir el ancho del navegador para mostrar cómo la barra lateral pasa a formato vertical y cómo el banner mantiene la proporción.
- Señalar ejemplos de atributos `alt` e íconos con `aria-label` que refuerzan la accesibilidad.【F:index.php†L89-L138】

### Grupo 4 – Organización del proyecto y buenas prácticas

**Teoría trabajada**

- Estructura modular de carpetas: separación de responsabilidades entre frontend (`estilos/`, `img/`), backend (`scripts/`), páginas (`pages/`) y archivos subidos (`uploads/`).
- Uso de Composer para gestionar dependencias (PHPMailer, Dotenv) y de `.env` para credenciales.
- Buenas prácticas de versionado con Git y plantillas de flujo de trabajo.

**Archivos y carpetas para mostrar durante la exposición**

1. Vista rápida del árbol de directorios en la raíz del repositorio para evidenciar la organización mencionada en el PDF.【F:readme.md†L1-L40】
2. `composer.json` y la carpeta `vendor/` instalada: evidencia del uso de dependencias externas gestionadas de forma profesional.【F:composer.json†L1-L39】
3. `scripts/responder_mensaje.php`: ejemplo concreto de cómo se cargan variables de entorno con Dotenv (`$dotenv->load()`) y se aprovechan las librerías incluidas por Composer.【F:scripts/responder_mensaje.php†L1-L30】
4. `plantilla_flujo_git.md`: recurso entregado al equipo para practicar un flujo Git colaborativo (pueden comentarlo brevemente si el jurado pregunta por metodologías).【F:plantilla_flujo_git.md†L1-L120】

**Tips para la demo**

- Explicar cómo la estructura facilita que nuevos integrantes encuentren rápidamente los archivos que necesitan modificar.
- Mencionar que el control de versiones y la organización por módulos son buenas prácticas profesionales que surgieron como aprendizaje clave del proyecto.

## Recorrido sugerido para la exposición

1. **Introducción conjunta** (todos): recordar los objetivos y el público al que se dirige la plataforma.
2. **Grupo 1**: iniciar sesión mostrando credenciales válidas, acceder al panel y cerrar sesión.
3. **Grupo 2**: desde el panel, crear una publicación de ejemplo, responder un mensaje y resaltar cómo queda registrado en la base.
4. **Grupo 3**: regresar a la página pública (`index.php`), refrescar y mostrar la nueva tarjeta publicada, explicar la adaptación responsiva.
5. **Grupo 4**: cerrar con el recorrido por las carpetas del repositorio y comentar el uso de Composer + Git para mantener el proyecto escalable.

## Frase de cierre sugerida

> “Este proyecto nos permitió aplicar programación, diseño, base de datos y trabajo en equipo para resolver una necesidad real de nuestra comunidad. Hoy presentamos un sitio seguro, organizado y accesible que evoluciona junto al Centro de Estudiantes”.

¡Éxitos en la exposición!
