<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/pedidos.php";
$pedidos = new Pedidos();

/* Revisa que el Puesto sea segun los Permisos para entrar a la Pagina */
$idUsuario = $_SESSION['idUsuario'];
$todosLosPedidos = $pedidos->mostrarPedidos();
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
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
        if (isset($_POST['confirmacion_'.$idPedidoCancelar]) && $_POST['confirmacion_'.$idPedidoCancelar] === 'si') {
            // Eliminar el pedido
            $pedidos->eliminarPedido($idPedidoCancelar);
            
            // Obtener todos los pedidos actualizados
            $todosLosPedidos = $pedidos->mostrarPedidos();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisar Pedidos</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
</head>

<body>
    <div class="container1">
        <h1 class="heading">Listado de Pedidos</h1>
        <!-- Revisa si se realzaron encuentros en la base de datos para luego mostrarlos -->
        <?php if (count($todosLosPedidos) > 0) { ?>
            <table class="user-table">
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
                    <tr>
                        <td><?php echo $pedido['idPedido']; ?></td>
                        <td><?php echo $pedido['idUsuario']; ?></td>
                        <td><?php echo $pedido['fechaPedido']; ?></td>
                        <td>
                            <form method="POST" action="revisarPedidos.php">
                                <input type="hidden" name="idPedido" value="<?php echo $pedido['idPedido']; ?>">
                                <select name="estado" class="status-select" onchange="this.form.submit()">
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
                                <button type="submit" class="cancel-button" onclick="return confirmarEliminacion(<?php echo $pedido['idPedido']; ?>)">Cancelar</button>
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

    <!-- Crea un popup de confirmacion para Eliminar de la base de datos -->
    <script>
        function confirmarEliminacion(idPedido) {
            var respuesta = confirm("¿Estás seguro de que deseas cancelar este pedido?");
            if (respuesta) {
                document.getElementById("confirmacion_" + idPedido).value = "si";
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>
