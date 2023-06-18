<?php
session_start();
include 'nav.php';
require_once 'conexiones/conexion.php';
require_once 'conexiones/Productos.php';
require_once 'conexiones/pedidos.php';

// Crear una instancia de la clase de conexión existente
$conexion = new Conexion();
$productos = new Productos();
$pedidos = new Pedidos();
// Verificar si se ha agregado algún producto al carrito
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = array(); // Crear un carrito vacío
}

// Procesar las acciones de quitar, aumentar y eliminar del carrito
if (isset($_GET['id']) && isset($_GET['action'])) {
    $idJuego = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'remove') {
        // Restar 1 a la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $_SESSION['carrito'][$idJuego]['cantidad'] -= 1;
            // Eliminar el producto si la cantidad es menor o igual a 0
            if ($_SESSION['carrito'][$idJuego]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$idJuego]);
            }
        }
    } elseif ($action == 'add') {
        // Sumar 1 a la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $_SESSION['carrito'][$idJuego]['cantidad'] += 1;
        }
    } elseif ($action == 'delete') {
        // Eliminar el producto del carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            unset($_SESSION['carrito'][$idJuego]);
        }
    }
    header('Location: carrito.php'); // Redirigir de vuelta a la página del carrito
    exit();
}
// Verificar si se ha enviado el formulario de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comprar'])) {
        $suficienteStock = true; // Bandera para verificar si hay suficiente stock
        foreach ($carrito as $idJuego => $juego) {
            $cantidad = $juego['cantidad'];
            // Verificar si hay suficiente stock antes de restar el stock
            if (!$productos->verificarStock($idJuego, $cantidad)) {
                $suficienteStock = false;
                echo "<div id='alerta' class='AlertaMala'>No se pudo realizar el pedido del producto: " . $juego['titulo'] . " debido a problemas de stock.</div>";
            }
        }
        if ($suficienteStock) {
            foreach ($carrito as $idJuego => $juego) {
                $cantidad = $juego['cantidad'];
                $productos->restarStock($idJuego, $cantidad);
            }
            //Consigue Los datos para posteriormente insertarlos en la BDD
            $idUsuario = $_SESSION['idUsuario'];
            $fechaPedido = date("Y-m-d H:i:s");
            $estado = "Pendiente";
            $detalles = ""; // Aquí se almacenarán los detalles de los productos del carrito
            $total = $_POST['total'];
            // Construir la cadena de detalles de los productos
            foreach ($carrito as $idJuego => $juego) {
                $titulo = $juego['titulo'];
                $cantidad = $juego['cantidad'];
                $subtotal = $juego['precio'] * $cantidad;
                $detalles .= "$titulo x  $cantidad ,";
            }
            // Insertar el pedido en la base de datos
            $insertado = $pedidos->realizarPedido($idUsuario, $fechaPedido, $estado, $detalles, $total);
            $idPedido = $pedidos->obtenerUltimoIdPedido();
            if ($insertado) {
                unset($_SESSION['carrito']);
                $_SESSION['pedido'] = array(
                    'idPedido' => $idPedido,
                    'fechaPedido' => $fechaPedido,
                    'estado' => $estado,
                    'detalles' => $detalles,
                    'total' => $total
                );
                echo "<div id='alerta' class='AlertaBuena'>El Pedido se Realizó Correctamente. <a class='boletaAlerta'  href='generar_boleta.php'>Descargar Boleta</a></div>";
            } else {
                echo "<div id='alerta' class='AlertaMala'>Error al realizar el pedido.</div>";
            }
        }
    }
}

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
                            <a class="button remove" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=remove">-</a>
                            <?php echo $juego['cantidad']; ?>
                            <a class="button add" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=add">+</a>
                        </td>
                        <td class="table-cell"><?php echo $subtotal; ?></td>
                        <td class="table-cell">
                            <a class="button delete" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=delete">Eliminar</a>
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