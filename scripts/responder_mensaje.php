<?php
session_start();
require_once 'conexion.php';
require_once 'validar_sesion.php';

// Cargar variables de entorno
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Validar que venga el id
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}
$id_mensaje = (int) $_GET['id'];

// Obtener mensaje
try {
    $stmt = $pdo->prepare("SELECT * FROM mensajes_contacto WHERE id = ?");
    $stmt->execute([$id_mensaje]);
    $mensaje = $stmt->fetch();

    if (!$mensaje) {
        die("Mensaje no encontrado.");
    }
} catch (PDOException $e) {
    die("Error al cargar datos: " . $e->getMessage());
}

// Procesar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $respuesta = $_POST['respuesta'];

    // Obtener el mensaje original
    $stmt = $pdo->prepare("SELECT * FROM mensajes_contacto WHERE id = ?");
    $stmt->execute([$id]);
    $mensaje = $stmt->fetch();

    if ($mensaje) {
        // Actualizar la respuesta en la base de datos
        $stmt = $pdo->prepare("UPDATE mensajes_contacto SET respuesta = ?, fecha_respuesta = NOW(), id_usuario_respuesta = ? WHERE id = ?");
        
        $stmt->execute([$respuesta, $_SESSION['usuario_id'], $id]);

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($_ENV['MAIL_USERNAME'], 'Centro de Estudiantes');
            $mail->addAddress($mensaje['email'], $mensaje['nombre']);
            $mail->Subject = "Respuesta a tu mensaje enviado al Centro de Estudiantes";
            $mail->CharSet = 'UTF-8';

            $cuerpo = "Hola " . $mensaje['nombre'] . ",\n\n";
            $cuerpo .= "Gracias por contactarte con nosotros. A continuación te dejamos nuestra respuesta:\n\n";
            $cuerpo .= $respuesta . "\n\n";
            $cuerpo .= "Saludos cordiales,\nCentro de Estudiantes";

            $mail->Body = $cuerpo;

            $mail->send();

            header('Location: dashboard.php?mensaje=Respuesta enviada y guardada correctamente');
            exit;
        } catch (Exception $e) {
            header('Location: dashboard.php?mensaje=Error al enviar el correo: ' . urlencode($mail->ErrorInfo));
            exit;
        }
    }
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
    <title>Responder Mensaje</title>
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
                    <li><a href="dashboard.php">Panel</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </aside>
        <main>
            <h2>Responder mensaje</h2>
            <div class="tarjeta" style="margin-bottom:2em;">
                <strong>Mensaje de:</strong> <?= htmlspecialchars($mensaje['nombre']) ?><br>
                <strong>Email:</strong> <?= htmlspecialchars($mensaje['email']) ?><br>
                <strong>Mensaje original:</strong><br>
                <?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?>
            </div>
            <form class="form-editarpublicacion" method="POST">
                <input type="hidden" name="id" value="<?= $mensaje['id'] ?>">
                <label for="respuesta">Respuesta:</label>
                <textarea name="respuesta" id="respuesta" rows="6" required><?= htmlspecialchars($mensaje['respuesta']) ?></textarea><br>
                <button type="submit" class="boton-principal">Guardar y enviar respuesta</button>
                <a href="dashboard.php" class="boton-secundario" style="margin-left:1em;">Cancelar</a>
            </form>
            <p><a href="dashboard.php">← Volver al panel</a></p>
        </main>
    </div>
</body>
</html>