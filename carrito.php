<?php
session_start(); // Iniciar sesión (si aún no está iniciada)

require_once 'conexiones/conexion.php';

// Crear una instancia de la clase de conexión existente
$conexion = new Conexion();
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

// Verificar si se ha enviado el formulario de inserción de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['imagen'])) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_POST['imagen'];

        // Insertar el producto en la base de datos
        $insertado = $productos->insertarProducto($titulo, $descripcion, $precio, $imagen);

        if ($insertado) {
            echo "Producto insertado correctamente.";
        } else {
            echo "Error al insertar el producto.";
        }
    }
}

// Verificar si se ha enviado el formulario de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comprar'])) {
        $idUsuario = $_SESSION['idUsuario'];
        $fechaPedido = date("Y-m-d");
        $estado = "Pendiente";
        $detalles = ""; // Aquí deberías obtener los detalles de los productos del carrito
        $total = $_POST['total'];

        // Insertar el pedido en la base de datos
        $query = "INSERT INTO Pedidos (idUsuario, fechaPedido, estado, detalles, total) VALUES ($idUsuario, '$fechaPedido', '$estado', '$detalles', $total)";
        $insertado = $conexion->query($query);

        if ($insertado) {
            echo "Pedido realizado correctamente.";
            unset($_SESSION['carrito']); // Vaciar el carrito después de hacer la compra
            $_SESSION['carrito'] = array();
        } else {
            echo "Error al realizar el pedido.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tfoot {
            font-weight: bold;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        a.button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin-right: 10px;
            float: right;
        }

        a.button.add {
            background-color: #2196F3;
            width: 20px;
            height: 20px;
        }

        a.button.remove {
            background-color: #FF5722;
            width: 20px;
            height: 20px;
        }

        a.button.delete {
            background-color: #F44336;
        }

        .product-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <h2>Carrito de compras</h2>

    <?php if (!empty($carrito)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Imagen</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($carrito as $idJuego => $juego) :
                    $subtotal = $juego['precio'] * $juego['cantidad'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?php echo $juego['titulo']; ?></td>
                        <td><img class="product-image" src="<?php echo $juego['imagen']; ?>" alt="<?php echo $juego['titulo']; ?>"></td>
                        <td><?php echo $juego['descripcion']; ?></td>
                        <td><?php echo $juego['precio']; ?></td>
                        <td>
                            <a class="button remove" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=remove">-</a>
                            <?php echo $juego['cantidad']; ?>
                            <a class="button add" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=add">+</a>
                        </td>
                        <td><?php echo $subtotal; ?></td>
                        <td>
                            <a class="button delete" href="actualizar_carrito.php?id=<?php echo $idJuego; ?>&action=delete">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">Total</td>
                    <td><?php echo $total; ?></td>
                </tr>
            </tfoot>
        </table>

        <?php if (isset($_SESSION['idUsuario'])) : ?>
            <form method="POST" action="carrito.php">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <button class="button" type="submit" name="comprar">Realizar compra</button>
            </form>
        <?php else : ?>
            <p><a href="index.php">Debes iniciar sesión para realizar la compra.</a></p>
        <?php endif; ?>

    <?php else : ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>

    <a class="button" href="tienda.php">Volver a la tienda</a>
</body>

</html>