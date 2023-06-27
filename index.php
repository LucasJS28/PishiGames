<?php
include 'nav.php';  
require_once "conexiones/Conexion.php";
session_start();
if (isset($_POST['correoUsuario']) && isset($_POST['passUsuario'])) {
    $correoUsuario = $_POST['correoUsuario'];
    $passUsuario = $_POST['passUsuario'];
    $conexion = new Conexion();
    $idRol = $conexion->login($correoUsuario, $passUsuario); //Entrega directamente el idRol
    if ($idRol !== false) {
        $usuarios = $conexion->obtenerUsuarios();
        foreach ($usuarios as $usuario) {
            if ($usuario['correoUsuario'] == $correoUsuario) { //Busca el idUsuario
                $idUsuario = $usuario['idUsuario']; 
                break;
            }
        }
        $_SESSION["idUsuario"] = $idUsuario; // Guardar el ID del usuario en la sesión

        switch ($idRol) {
            case 1:
                header("Location: administracion/panelAdministrador.php");
                $_SESSION["Puesto"] = "Administrador";
                break;
            case 2:
                header("Location: administracion/panelTrabajador.php");
                $_SESSION["Puesto"] = "Trabajador";
                break;
            case 3:
                header("Location: administracion/panelJefe.php");
                $_SESSION["Puesto"] = "Jefe";
                break;
            case 4:
                header("Location: tienda.php");
                $_SESSION["Puesto"] = "Usuario";
                if ($_SESSION['carrito']) { //En caso del usuario haber estado usando el carrito y necesita iniciar sesion esto lo enviara al carrito enves de a la tiendaPrincipal
                    header("Location: carrito.php"); 
                }
                break;
            default:
                break;
        }
        exit;
    } else {
        echo "<div id='alerta' class='AlertaMala'>Credenciales incorrectas. Inténtalo nuevamente.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Principal</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="estilos/styles2.css">
    <script src="scripts/scriptsValidaciones.js"></script>
</head>

<body>
    <section>
        <h2>Iniciar Sesion</h2>
        <p>Nuevo Usuario? <a href="registroUsuarios.php">!!Registrate!!</a></p>
        <form action="index.php" method="POST" onsubmit="return validarFormularioLogin()">
        <input type="email" id="correoUsuario" name="correoUsuario" placeholder="Ingrese su Correo Electronico:" required><br><br>
            <input type="password" id="passUsuario" name="passUsuario" placeholder="Ingrese la Contraseña"><br><br>
            <br><input type="submit" id="iniciar" value="Iniciar Sesion">
            <p>No tienes Cuenta? <a href="registroUsuarios.php">Registrate</a></p><br>
        </form>
    </section>
    <article>
        <h2>Bienvenido</h2>
    </article>
</body>

</html>