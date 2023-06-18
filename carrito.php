<?php
    require_once 'acciones_carrito.php';
    include 'nav.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <link rel="stylesheet" href="estilos/style.css">
    <script src="scripts/scripts.js" defer></script>
    <link rel="stylesheet" href="estilos/styles2.css">
</head>

<body>
    <h2 class="heading">Carrito de compras</h2>

    <?php if (isset($_SESSION['idUsuario'])) { ?>
        <form method="POST" action="historialPedidos.php">
            <a class="HistorialPedidos" href="historialPedidos.php">Ir al Historial de Pedidos</a>
        </form>
    <?php } ?>

    <style>
        <?php if (!isset($_SESSION['idUsuario'])) { ?>.HistorialPedidos {
            display: none;
        }
        <?php } ?>
    </style>

    <?php if (!empty($carrito)) { ?>
        <table class="table">
            <thead>
                <tr class="table-row">
                    <th class="table-header">Producto</th>
                    <th class="table-header">Imagen</th>
                    <th class="table-header">Descripción</th>
                    <th class="table-header">Precio</th>
                    <th class="table-header">Cantidad</th>
                    <th class="table-header">Subtotal</th>
                    <th class="table-header">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrito as $idJuego => $juego) {
                    $subtotal = $juego['precio'] * $juego['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr class="table-row">
                        <td class="table-cell"><?php echo $juego['titulo']; ?></td>
                        <td class="table-cell"><img class="product-image" src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['titulo']; ?>"></td>
                        <td class="table-cell"><?php echo $juego['descripcion']; ?></td>
                        <td class="table-cell"><?php echo $juego['precio']; ?></td>
                        <td class="table-cell">
                            <a class="button remove" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=remove">-</a>
                            <?php echo $juego['cantidad']; ?>
                            <a class="button add" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=add">+</a>
                        </td>
                        <td class="table-cell"><?php echo $subtotal; ?></td>
                        <td class="table-cell">
                            <a class="button delete" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=delete">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr class="table-row">
                    <td class="table-cell" colspan="6">Total</td>
                    <td class="table-cell"><?php echo $total; ?></td>
                </tr>
            </tfoot>
        </table>

        <?php if (isset($_SESSION['idUsuario'])) { ?>
            <form method="POST" action="carrito.php">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button class="button" type="submit" name="comprar">Realizar compra</button>
            </form>
        <?php } else { ?>
            <p class="centered-text"><a href="index.php">Debes iniciar sesión para realizar la compra.</a></p>
        <?php } ?>

    <?php } else { ?>
        <p class="centered-text">No hay productos en el carrito.</p>
    <?php } ?>

    <a class="button" href="tienda.php">Volver a la tienda</a>
</body>

</html>