<?php
session_start();
require_once 'conexiones/pedidos.php';
$pedidos = new Pedidos();
$idUsuario = $_SESSION['idUsuario'];
$todosLosPedidos = $pedidos->mostrarPedidos();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}

$permiso = $_SESSION["Puesto"];

if ($permiso !== "Trabajador" && $permiso !== "Administrador") {
    header("Location: index.php");
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
        $idPedido = $_POST['idPedidoCancelar'];
        
        // Agrega una validación adicional antes de cancelar el pedido
        if (isset($_POST['confirmacion']) && $_POST['confirmacion'] === 'si') {
            // Eliminar el pedido
            $pedidos->eliminarPedido($idPedido);
            
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
    <style>
        body {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .cancel-button {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
        }

        .status-select {
            font-size: 14px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <div>
        Bienvenido: <?php echo $permiso; ?> <a href="cerrarsesion.php">Cerrar Sesion</a><br>
        <?php
        if ($permiso == "Administrador") {
            echo "<a href='panelAdministrador.php'>Volver al Panel de Administracion</a>";
        }
        ?><br>
        <a href="panelTrabajador.php">Volver al Añadir Productos</a>
    </div>
    <h1>Listado de Pedidos</h1>
    <?php
    if (count($todosLosPedidos) > 0) : ?>
        <table>
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
                        <form method="POST" action="">
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
                        <form method="POST" action="">
                            <input type="hidden" name="idPedidoCancelar" value="<?= $pedido['idPedido'] ?>">
                            <button type="submit" class="cancel-button" onclick="return confirmarEliminacion()">Cancelar</button>
                            <input type="hidden" name="confirmacion" id="confirmacion" value="">
                        </form>
                    </td>

                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No se encontraron pedidos.</p>
    <?php endif; ?>
</body>
<script>
    function confirmarEliminacion() {
        var respuesta = confirm("¿Estás seguro de que deseas cancelar este pedido?");
        if (respuesta) {
            document.getElementById("confirmacion").value = "si";
            return true;
        } else {
            return false;
        }
    }
</script>

</html>