<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Conexion.php";
$conexion = new Conexion();

/* Verifica que exista un usuario logeado */
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}

/* Verifica que el Usuario sea un administrador en caso de no serlo lo reenvía al login */
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Administrador") {
    header("Location:../index.php");
    exit();
}
// Desactivar la caché del servidor
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

/* Realiza el Registro de Usuarios administradores, jefes o trabajadores en la Base de Datos */
if ($_POST) {
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : "";
    $rol = isset($_POST["rol"]) ? $_POST["rol"] : "";
    try {
        // Código que puede generar la excepción
        $registroExitoso = $conexion->register($correo, $contrasena, $rol);
        if ($registroExitoso) {
            $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Registro Realizado con Éxito</div>";
            header("Location: panelAdministrador.php"); // Redirecciona a la página actualizada
            exit();
        } else {
            $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al Registrar</div>";
        }
    } catch (PDOException $e) {
        // Manejo de la excepción
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>El Correo ya se Encuentra Registrado</div>";
    }
}

/* Elimina un usuario */
if (isset($_POST["eliminarUsuario"])) {
    $correoUsuario = $_POST["eliminarUsuario"];
    $eliminacionExitosa = $conexion->eliminarUsuario($correoUsuario);
    if ($eliminacionExitosa) {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Usuario eliminado exitosamente</div>";
        echo "delete";
        header("Location: panelAdministrador.php"); // Redirecciona a la página actualizada
        exit();
    } else {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al eliminar el usuario</div>";
        echo "error";
    }
    exit();
}

/* Actualiza el rol de un usuario */
if (isset($_POST["correoUsuario"]) && isset($_POST["rol"])) {
    $correoUsuario = $_POST["correoUsuario"];
    $rol = $_POST["rol"];
    $actualizacionExitosa = $conexion->modificarRol($correoUsuario, $rol);
    if ($actualizacionExitosa) {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaBuena'>Se Modificó el Rol de manera Exitosa</div>";
        echo "success";
    } else {
        $_SESSION['alerta'] = "<div id='alerta' class='AlertaMala'>Error al Modificar el Rol</div>";
        echo "error";
    }
    exit();
}

if (isset($_SESSION['alerta'])) {
    $alerta = $_SESSION['alerta'];
    echo $alerta;
    unset($_SESSION['alerta']);
}

$usuarios = $conexion->obtenerUsuarios();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Trabajadores</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/scriptsValidaciones.js"></script>
    <script src="../scripts/ajax.js"></script>
</head>

<body>
    <div class="contenedor">
        <h1 class="titulo">Registro de Trabajadores</h1>
        <form action="panelAdministrador.php" method="POST" onsubmit="return validarFormularioRegistroAdmin()">
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
        <h2 class="titulo-registrados">Usuarios Registrados</h2>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Correo</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese el Correo a buscar">
        </div>
        <table class="tabla-principal">
            <thead>
                <tr>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr id="fila-<?php echo $usuario['correoUsuario']; ?>" class="correoUsuario">
                        <td>
                            <?php echo $usuario['correoUsuario']; ?>
                        </td>
                        <td data-correo="<?php echo $usuario['correoUsuario']; ?>">
                            <select onchange="actualizarRol('<?php echo $usuario['correoUsuario']; ?>', this.value)">
                                <option value="1" <?php if ($usuario['ID_Rol'] == "1") echo 'selected'; ?>>Administrador</option>
                                <option value="3" <?php if ($usuario['ID_Rol'] == "3") echo 'selected'; ?>>Jefe</option>
                                <option value="2" <?php if ($usuario['ID_Rol'] == "2") echo 'selected'; ?>>Trabajador</option>
                                <option value="4" <?php if ($usuario['ID_Rol'] == "4") echo 'selected'; ?>>Usuario</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="button-eliminar" onclick="eliminarUsuario('<?php echo $usuario['correoUsuario']; ?>')">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>