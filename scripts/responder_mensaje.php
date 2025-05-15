<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $respuesta = $_POST['respuesta'];

    // Obtener el mensaje original
    $stmt = $pdo->prepare("SELECT * FROM mensajes_contacto WHERE id = ?");
    $stmt->execute([$id]);
    $mensaje = $stmt->fetch();

    if ($mensaje) {
        // Actualizar la respuesta en la base de datos
        $stmt = $pdo->prepare("UPDATE mensajes_contacto SET respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
        $stmt->execute([$respuesta, $id]);

        // Enviar el correo
        $para = $mensaje['email'];
        $asunto = "Respuesta a tu mensaje enviado al Centro de Estudiantes";
        $cabeceras = "From: sergiodserbluk@gmail.com\r\n";
        $cabeceras .= "Content-type: text/plain; charset=UTF-8\r\n";

        $cuerpo = "Hola " . $mensaje['nombre'] . ",\n\n";
        $cuerpo .= "Gracias por contactarte con nosotros. A continuación te dejamos nuestra respuesta:\n\n";
        $cuerpo .= $respuesta . "\n\n";
        $cuerpo .= "Saludos cordiales,\nCentro de Estudiantes";

        mail($para, $asunto, $cuerpo, $cabeceras);

        header('Location: dashboard.php?mensaje=Respuesta enviada y guardada correctamente');
        exit;
    }
}

// Si es GET, mostrar el formulario
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM mensajes_contacto WHERE id = ?");
$stmt->execute([$id]);
$mensaje = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder mensaje</title>
</head>
<body>
    <h1>Responder mensaje de <?= htmlspecialchars($mensaje['nombre']) ?></h1>
    <p><strong>Mensaje original:</strong> <?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?></p>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $mensaje['id'] ?>">
        <label for="respuesta">Respuesta:</label><br>
        <textarea name="respuesta" rows="6" cols="50"><?= htmlspecialchars($mensaje['respuesta']) ?></textarea><br><br>
        <button type="submit">Guardar y enviar respuesta</button>
        <a href="dashboard.php">Cancelar</a>
    </form>
</body>
</html>
