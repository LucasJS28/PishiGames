<?php 
require_once "conexiones/Conexion.php";

if ($_POST) {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    $conexion = new Conexion();
    $registroExitoso = $conexion->register($correo, $contrasena, $rol);

    if ($registroExitoso) {
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el usuario";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Registro de Usuarios</h1>
        <form action="registroUsuarios.php" method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" id="correo" required>
            <br>
            <label for="contrasena">Contraseña:</label>
            <input type="hidden" name="rol" value="4">
            <input type="password" name="contrasena" id="contrasena" required><br>
            <input type="submit" value="Registrarse"><br>
            <a href="index.php">Volver al Login</a>
        </form>
</body>
</html>