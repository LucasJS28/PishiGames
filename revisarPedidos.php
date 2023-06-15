<?php
session_start();
require_once 'conexiones/pedidos.php';
$pedidos = new Productos();
$idUsuario = $_SESSION['idUsuario'];

// Obtener todos los pedidos
$todosLosPedidos = $pedidos->mostrarPedidos();

// Procesar el formulario de cambio de estado o cancelación de pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idPedido'])) {
        $idPedido = $_POST['idPedido'];
        $estado = $_POST['estado'];
        
        // Actualizar el estado del pedido
        $pedidos->actualizarEstadoPedido($idPedido, $estado);
    } elseif (isset($_POST['idPedidoCancelar'])) {
        $idPedido = $_POST['idPedidoCancelar'];
        
        // Eliminar el pedido
        $pedidos->eliminarPedido($idPedido);
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
        body{
            margin:0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
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
    <h1>Listado de Pedidos</h1>
    <?php 
    if (count($todosLosPedidos) > 0): ?>
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

            <?php foreach ($todosLosPedidos as $pedido): ?>
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
                            <button type="submit" class="cancel-button">Cancelar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No se encontraron pedidos.</p>
    <?php endif; ?>
</body>
</html>
