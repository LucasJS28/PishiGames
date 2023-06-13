<?php
     require_once('Conexion.php');
    
     if (isset($_POST['correoUsuario']) && isset($_POST['passUsuario'])) {
         $correoUsuario = $_POST['correoUsuario'];
         $passUsuario = $_POST['passUsuario'];
         
         $conexion = new Conexion();
         $idRol = $conexion->login($correoUsuario, $passUsuario);
         
         if ($idRol !== false) {
             switch ($idRol) {
                 case 1:
                     header("Location: pagina1.php");
                     break;
                 case 2:
                     header("Location: pagina2.php");
                     break;
                 case 3:
                     header("Location: pagina3.php");
                     break;
                 default:
                     echo "ID_Rol no válido.";
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
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form action="index.php" method="POST">
        <label for="correoUsuario">Correo electrónico:</label>
        <input type="email" id="correoUsuario" name="correoUsuario" required><br><br>
        
        <label for="passUsuario">Contraseña:</label>
        <input type="password" id="passUsuario" name="passUsuario" required><br><br>
        
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>