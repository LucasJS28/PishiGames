<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/pedidos.php";
$pedidos = new Pedidos();
$idUsuario = $_SESSION['idUsuario'];
$permiso = $_SESSION["Puesto"];
$todosLosPedidos = $pedidos->mostrarPedidos();

if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}
if ($permiso !== "Trabajador" && $permiso !== "Administrador" && $permiso !== "Jefe") {
    header("Location:../index.php");
    exit();
}

// Procesar el formulario de cambio de estado o cancelación de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idPedido'])) {
        $idPedido = $_POST['idPedido'];
        $estado = $_POST['estado'];
        // Actualizar el estado del pedido
        $pedidos->actualizarEstadoPedido($idPedido, $estado);
        // Obtener todos los pedidos actualizados
        $todosLosPedidos = $pedidos->mostrarPedidos();
    } elseif (isset($_POST['idPedidoCancelar'])) {
        $idPedidoCancelar = $_POST['idPedidoCancelar'];
        // Agrega una validación adicional antes de cancelar el pedido
        if (isset($_POST['confirmacion_' . $idPedidoCancelar]) && $_POST['confirmacion_' . $idPedidoCancelar] === 'si') {
            // Eliminar el pedido
            $pedidos->eliminarPedido($idPedidoCancelar);

            // Obtener todos los pedidos actualizados
            $todosLosPedidos = $pedidos->mostrarPedidos();
        }
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Pedidos</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/scriptsValidaciones.js"></script>
    <script src="../scripts/ajax.js"></script>
</head>

<body>
    <div class="contenedor-tabla">
        <h1 class="titulo">Listado de Pedidos</h1>
        <!-- Revisa si se realizaron encuentros en la base de datos para luego mostrarlos -->
        <?php if (count($todosLosPedidos) > 0) { ?>
            <table class="tabla-principal">
                <tr>
                    <th>ID Pedido</th>
                    <th>ID Usuario</th>
                    <th>Fecha Pedido</th>
                    <th>Estado</th>
                    <th>Detalles</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>

                <?php foreach ($todosLosPedidos as $pedido) { ?>
                    <!-- genera un atributo id único para cada fila 
                    en la tabla de pedidos. El atributo id es utilizado para identificar y seleccionar esa fila específica mediante JavaScript. -->
                    <tr id="fila-<?php echo $pedido['idPedido']; ?>"> 
                        <td><?php echo $pedido['idPedido']; ?></td>
                        <td><?php echo $pedido['idUsuario']; ?></td>
                        <td><?php echo $pedido['fechaPedido']; ?></td>
                        <td>
                            <form method="POST" action="revisarPedidos.php">
                                <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                <select name="estado" class="cambio-estado" onchange="actualizarEstadoPedido(<?php echo $pedido['idPedido']; ?>, this.value)">
                                    <option value="Pendiente" <?php if ($pedido['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                    <option value="En proceso" <?php if ($pedido['estado'] === 'En proceso') echo 'selected'; ?>>En proceso</option>
                                    <option value="Completado" <?php if ($pedido['estado'] === 'Completado') echo 'selected'; ?>>Completado</option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo $pedido['detalles']; ?></td>
                        <td><?php echo $pedido['total']; ?></td>
                        <td>
                            <form method="POST" action="revisarPedidos.php">
                                <input type="hidden" name="idPedidoCancelar" value="<?php echo $pedido['idPedido']; ?>">
                                <button type="button" class="boton-eliminar" onclick="eliminarPedido(<?php echo $pedido['idPedido']; ?>)">Cancelar</button>
                                <input type="hidden" name="confirmacion_<?php echo $pedido['idPedido']; ?>" id="confirmacion_<?php echo $pedido['idPedido']; ?>" value="">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-pedidos">No se encontraron pedidos.</p>
        <?php } ?>
    </div>
</body>

</html>