<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/favicon/favicon.ico" type="image/x-icon">
    <title>Registrarse</title>
</head>
<body>
    <h2>Crear cuenta</h2>
    <form action="procesar_registro.php" method="post">
        <label for="nombre_usuario">Nombre de usuario:</label>
        <input type="text" name="nombre_usuario" required>
        <br>
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" required>
        <br>
        <label for="clave">Contraseña:</label>
        <input type="password" name="clave" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>
