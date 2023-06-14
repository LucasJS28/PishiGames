<?php
session_start(); // Iniciar sesión (si aún no está iniciada)

require_once 'conexiones/crudProductos.php';

// Crear una instancia de la clase Productos
$productos = new Productos();

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
    <?php else : ?>
        <p>No se ha agregado ningún producto al carrito.</p>
    <?php endif; ?>
    <br>
    <br>
    <br>
    <a class="button" href="pagos.php?total=<?php echo $total; ?>">Comprar Carrito</a>
    <a class="button" href="tienda.php">Volver a la tienda</a>
</body>

</html>
