<?php
require_once "Conexion.php";
session_start();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Administrador") {
    header("Location: index.php");
    exit();
}
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
    <div>
        Bienvenido: <?php echo $permiso;?>
    </div>

    <h1>Registro de Usuario</h1>
    <form action="panelAdministrador.php" method="POST">
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" required>
        <br>
        <label for="rol">Rol:</label>
        <select name="rol" id="rol" required>
            <option value="1">Administrador</option>
            <option value="3">Jefe</option>
            <option value="2">Trabajador</option>
        </select>
        <br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>