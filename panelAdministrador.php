<?php
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
$conexion = new Conexion();
$usuarios = $conexion->obtenerUsuarios();
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
        Bienvenido: <?php echo $permiso;?> <a href="cerrarsesion.php">Cerrar Sesion</a><br>
        <a href="panelTrabajador.php">Ir al Registro de Productos</a>
    </div>

    <h1>Registro de Trabajadores</h1>
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
    <br>
    <br>
    <h2>Usuarios Registrados</h2>
    <table border="1">
        <tr>
            <th>Correo Electrónico</th>
            <th>Rol</th>
        </tr>
        <?php foreach ($usuarios as $usuario) { ?>
            <tr>
                <td><?php echo $usuario['correoUsuario']; ?></td>
                <td><?php 
                    if ($usuario['ID_Rol']=="1") {
                        echo "Administrador";
                    }
                    if ($usuario['ID_Rol']=="2") {
                        echo "Trabajador";
                    }
                    if ($usuario['ID_Rol']=="3") {
                        echo "Jefe";
                    }
                    if ($usuario['ID_Rol']=="4") {
                        echo "Usuario";
                    }; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>