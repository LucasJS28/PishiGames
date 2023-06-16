<?php 
    session_start();
    include 'nav.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
    <h2 class="heading">Lista de Pedidos</h2>

    <?php
    require_once 'conexiones/pedidos.php';
    $pedido = new Pedidos();
    $idUsuario = $_SESSION['idUsuario'];

    // Llamar a la función mostrarPedidosxUsuario para obtener los pedidos del usuario
    $pedidos = $pedido->mostrarPedidosxUsuario($idUsuario);

    if (!empty($pedidos)) :
    ?>
        <table class="table">
            <thead>
                <tr class="table-row">
                    <th class="table-header">ID del Pedido</th>
                    <th class="table-header">Fecha del Pedido</th>
                    <th class="table-header">Estado</th>
                    <th class="table-header">Detalles</th>
                    <th class="table-header">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido) : ?>
                    <tr class="table-row">
                        <td class="table-cell"><?php echo $pedido['idPedido']; ?></td>
                        <td class="table-cell"><?php echo $pedido['fechaPedido']; ?></td>
                        <td class="table-cell"><?php echo $pedido['estado']; ?></td>
                        <td class="table-cell"><?php echo $pedido['detalles']; ?></td>
                        <td class="table-cell"><?php echo $pedido['total']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="centered-text">No hay pedidos disponibles.</p>
    <?php endif; ?>

    <a class="button" href="carrito.php">Volver al Carrito de Compras</a>
</body>

</html>