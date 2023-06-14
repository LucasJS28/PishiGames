<?php
require_once "conexiones/Conexion.php";

if ($_POST) {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];
    $repecontra = $_POST["repecontra"];
    $rol = $_POST["rol"];
    if ($contrasena == $repecontra) {
        $conexion = new Conexion();
        $registroExitoso = $conexion->register($correo, $contrasena, $rol);

        if ($registroExitoso) {
            echo "Registro exitoso";
        } else {
            echo "Error al registrar el usuario";
        }
    } else {
        echo "Ambas Contraseñas deben ser Identicas";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
    <form action="registroUsuarios.php" method="POST" class="formu">
        <h2 id="titulo">Registro de Usuarios</h2>          
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        <br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="hidden" name="rol" value="4">
        <input type="password" name="contrasena" id="contrasena" required>
        <br><br>
        <label for="contrasena">Repetir Contraseña:</label>
        <input type="hidden" name="rol" value="4">
        <input type="password" name="repecontra" id="repecontra" required>
        <br><br>
        <input type="checkbox" name="terminos" id="terminos" required>Acepto los Terminos y Condiciones
        <br>
        <br>
        <input type="submit" value="Registrarse">
        <br><br>
        <a href="index.php">Volver al Login</a>
    </form>
</body>

</html>