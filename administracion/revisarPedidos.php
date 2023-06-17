<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/pedidos.php";
$pedidos = new Pedidos();

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


<<!DOCTYPE html>
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
        <?php if (count($todosLosPedidos) > 0) : ?>
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

                <?php foreach ($todosLosPedidos as $pedido) : ?>
                    <tr>
                        <td><?= $pedido['idPedido'] ?></td>
                        <td><?= $pedido['idUsuario'] ?></td>
                        <td><?= $pedido['fechaPedido'] ?></td>
                        <td>
                            <form method="POST" action="revisarPedidos.php">
                                <input type="hidden" name="idPedido" value="<?= $pedido['idPedido'] ?>">
                                <select name="estado" class="status-select" onchange="this.form.submit()">
                                    <option value="Pendiente" <?= ($pedido['estado'] === 'Pendiente') ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="En proceso" <?= ($pedido['estado'] === 'En proceso') ? 'selected' : '' ?>>En proceso</option>
                                    <option value="Completado" <?= ($pedido['estado'] === 'Completado') ? 'selected' : '' ?>>Completado</option>
                                </select>
                            </form>
                        </td>
                        <td><?= $pedido['detalles'] ?></td>
                        <td><?= $pedido['total'] ?></td>
                        <td>
                            <form method="POST" action="revisarPedidos.php">
                                <input type="hidden" name="idPedidoCancelar" value="<?= $pedido['idPedido'] ?>">
                                <button type="submit" class="cancel-button" onclick="return confirmarEliminacion(<?= $pedido['idPedido'] ?>)">Cancelar</button>
                                <input type="hidden" name="confirmacion_<?= $pedido['idPedido'] ?>" id="confirmacion_<?= $pedido['idPedido'] ?>" value="">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p class="no-pedidos">No se encontraron pedidos.</p>
        <?php endif; ?>
    </div>

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
