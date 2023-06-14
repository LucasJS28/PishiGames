<?php
    require_once "conexiones/Conexion.php";
    session_start();
    if (isset($_POST['correoUsuario']) && isset($_POST['passUsuario'])) {
         $correoUsuario = $_POST['correoUsuario'];
         $passUsuario = $_POST['passUsuario'];
         
         $conexion = new Conexion();
         $idRol = $conexion->login($correoUsuario, $passUsuario);
         
         if ($idRol !== false) {
             switch ($idRol) {
                 case 1:
                     header("Location: panelAdministrador.php");
                     $_SESSION["Puesto"]="Administrador";
                     break;
                 case 2:
                     header("Location: panelTrabajador.php");
                     $_SESSION["Puesto"]="Trabajador";
                     break;
                 case 3:
                     header("Location: panelJefe.php");
                     $_SESSION["Puesto"]="Jefe";
                     break;
                case 4:
                    header("Location: tienda.php");
                    $_SESSION["Puesto"]="Usuario";
                    break;
                 default:
                     break;
             }
             exit;
         } else {
             echo "Credenciales incorrectas. Inténtalo nuevamente.";
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
    <form action="index.php" method="POST" class="formu">
        <h2 id="titulo">Iniciar sesión</h2>
        <label for="correoUsuario">Correo electrónico:</label>
        <input type="email" id="correoUsuario" name="correoUsuario" required><br><br>
        
        <label for="passUsuario">Contraseña:</label>
        <input type="password" id="passUsuario" name="passUsuario" required><br><br>
        <input type="submit" value="Iniciar sesión">
        <p>No tienes Cuenta? <a href="registroUsuarios.php">Registrate</a></p><br>
        <a href="tienda.php">Volver a la Tienda</a>
    </form>
</body>
</html>