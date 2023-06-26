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
    <link rel="stylesheet" href="estilos/styles2.css">
    <script src="scripts/scripts.js"></script>
</head>

<body>
    <h2 class="heading">Carrito de compras</h2>
    <!-- Habilita el boton de historial de pedidos si es que el usuario tiene una sesion iniciaca -->
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
    <!-- Muestra los Productos que fueron Añadidos al Carro -->
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
                $total = 0; // Agregar esta línea para inicializar $total
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
                            <!-- se envía una solicitud a "acciones_carrito.php" con los parámetros "id" y "action" establecidos en los valores correspondientes -->
                            <a class="button remove" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=remove">-</a>
                            <?php echo $juego['cantidad']; ?>
                            <a class="button add" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=add">+</a>
                        </td>
                        <td class="table-cell"><?php echo $subtotal; ?></td>
                        <td class="table-cell"><a class="button delete" href="acciones_carrito.php?id=<?php echo $idJuego; ?>&action=delete">Eliminar</a></td>
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

        <!-- Crea el formulario de venta para posteriormente hacerlo aparecer o desaparecer -->
        <?php if (isset($_SESSION['idUsuario'])) { ?>
            <form class="formulario-compra" method="POST" action="carrito.php">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button id="realizar-compra" class="button" type="submit" name="comprar">Realizar compra</button>
            </form>
            <div id="modal-overlay" class="modal-overlay"></div>
            <div id="modal-content" class="formulario-popup">
                <form class="formulario-compra" method="POST" action="carrito.php">
                    <br>
                    <h3>Formulario de Compra</h3>
                    <label for="total">Total a Pagar</label>
                    <input name="total" value="<?php echo $total; ?>">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="txtnombre" required>
                    <label for="direccion">Numero de Tarjeta</label>
                    <input type="text" id="tarjeta" name="tarjeta" class="txtTarjeta" required>
                    <label for="ciudad">CVV</label>
                    <input type="text" id="CVV" name="CVV" class="CVV" required>
                    <label for="pais">Codigo Postal</label>
                    <input type="text" id="cPostal" name="cPostal" class="cPostal" required>
                    <button id="realizarr-compra" type="submit" name="comprar">Realizar compra</button>
                    <button id="cancelar-compra" type="button">Cancelar compra</button>
                    <br>
                    <br>
                </form>
            </div>
        <?php } else { ?>
            <p class="centered-text"><a href="index.php">Debes iniciar sesión para realizar la compra.</a></p>
        <?php } ?>

    <?php } else { ?>
        <p class="centered-text">No hay productos en el carrito.</p>
    <?php } ?>

    <a class="button" href="tienda.php">Volver a la tienda</a>

    <script>
        // JavaScript para mostrar y ocultar el formulario de compra
        document.addEventListener("DOMContentLoaded", function() {
            var modalOverlay = document.getElementById("modal-overlay");
            var modalContent = document.getElementById("modal-content");
            var realizarCompraButton = document.getElementById("realizar-compra");
            var cancelarCompraButton = document.getElementById("cancelar-compra");

            // Evento de clic para mostrar el formulario de compra
            realizarCompraButton.addEventListener("click", function(e) {
                e.preventDefault();
                modalOverlay.classList.add("active"); // Agrega la clase "active" al modal-overlay para mostrarlo
                modalContent.classList.add("active"); // Agrega la clase "active" al modal-content para mostrarlo
            });

            // Evento de clic para cancelar la compra y ocultar el formulario
            cancelarCompraButton.addEventListener("click", function() {
                modalOverlay.classList.remove("active"); // Remueve la clase "active" del modal-overlay para ocultarlo
                modalContent.classList.remove("active"); // Remueve la clase "active" del modal-content para ocultarlo
            });

            // Evento de clic en el fondo del modal para ocultar el formulario
            modalOverlay.addEventListener("click", function() {
                modalOverlay.classList.remove("active"); // Remueve la clase "active" del modal-overlay para ocultarlo
                modalContent.classList.remove("active"); // Remueve la clase "active" del modal-content para ocultarlo
            });
        });
    </script>

</body>

</html>