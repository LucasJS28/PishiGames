<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Conexion.php";
$conexion = new Conexion();
$usuarios = $conexion->obtenerUsuarios();

/* Verifica que exista un usuario logeado */
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}

/* Verifica que el Usuario sea un administrador en caso de no serlo lo reenvia al login */
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Administrador") {
    header("Location:../index.php");
    exit();
}

/* Realiza el Registro de Usuarios administradores jefes o trabajadores a la Base de Datos */
if ($_POST) {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"]; 
    $rol = $_POST["rol"];
    $registroExitoso = $conexion->register($correo, $contrasena, $rol);
    if ($registroExitoso) {
        echo "<div id='alerta' class='AlertaBuena'>Registro Realizado Correctamente</div>";
        header("Location: panelAdministrador.php"); // Redirecciona a la página actualizada
    } else {
        echo "<div id='alerta' class='AlertaMala'>Error al Realizar el Registro</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Trabajadores</title>
  <link rel="stylesheet" href="../estilos/stylesAdm.css">
</head>
<body>
  <div class="contenedor">
    <h1 class="titulo">Registro de Trabajadores</h1>
    <form action="panelAdministrador.php" method="POST">
      <label for="correo">Correo electrónico:</label>
      <input type="email" name="correo" id="correo" required >
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
    <h2 class="titulo-registrados">Usuarios Registrados</h2>
    <table class="tabla-principal">
      <thead>
        <tr>
          <th>Correo Electrónico</th>
          <th>Rol</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $usuario) { ?>
        <tr>
          <td>
            <?php echo $usuario['correoUsuario']; ?>
          </td>

          <!-- Transforma el ID_Rol en el Rol asignado para mayor entiendimiento del Usuario -->
          <td id="roles">
            <?php 
              if ($usuario['ID_Rol'] == "1") {
                echo "Administrador";
              }
              if ($usuario['ID_Rol'] == "2") {
                echo "Trabajador";
              }
              if ($usuario['ID_Rol'] == "3") {
                echo "Jefe";
              }
              if ($usuario['ID_Rol'] == "4") {
                echo "Usuario";
              }
            ?>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>

</html>
