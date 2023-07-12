<?php
session_start();
include_once 'nav.php';
require_once 'conexiones/Productos.php';

// Crear una instancia de la clase Productos
$productos = new Productos();
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

// Verificar si se ha agregado algún producto al carrito
if (isset($_SESSION['carrito'])) {
    $carrito = $_SESSION['carrito'];
} else {
    $carrito = array(); // Crear un carrito vacío
}

// Verificar si se ha enviado el formulario de agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarCarrito'])) {
    $idJuego = $_POST['idJuego'];

    // Verificar si el juego ya está en el carrito
    if (array_key_exists($idJuego, $_SESSION['carrito'])) {
        // Verificar si hay suficiente stock antes de incrementar la cantidad
        if ($productos->verificarStock($idJuego, $_SESSION['carrito'][$idJuego]['cantidad'] + 1)) {
            $_SESSION['carrito'][$idJuego]['cantidad']++; // Incrementar la cantidad si hay suficiente stock
            echo "<div id='alerta' class='AlertaBuena'>Se añadió una nueva copia al Carro. Cantidad: " . $_SESSION['carrito'][$idJuego]['cantidad'] . "</div>";
            header('Location: detalles_juego.php ');
        } else {
            echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
            header('Location: detalles_juego.php ');
        }
    } else {
        // Obtener los detalles del producto según el ID
        $juego = $productos->obtenerProducto($idJuego);

        // Verificar si se encontró el producto
        if ($juego) {
            // Verificar si hay suficiente stock antes de agregar el producto al carrito
            if ($productos->verificarStock($idJuego, 1)) {
                $_SESSION['carrito'][$idJuego] = array(
                    'titulo' => $juego['titulo'],
                    'descripcion' => $juego['descripcion'],
                    'imagen' => $juego['imagen'],
                    'precio' => $juego['precio'],
                    'cantidad' => 1
                );
                echo "<div id='alerta' class='AlertaBuena'>Se añadió al Carrito Cantidad:1</div>";
                header('Location: detalles_juego.php ');
            } else {
                echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
                header('Location: detalles_juego.php ');
            }
        }
    }

    exit; // Detener la ejecución del resto del código para evitar recargar la página completa
}

// Obtener el ID del juego de la URL
$idJuego = $_GET['id'];

// Verificar si se encontró el juego
$juego = $productos->obtenerProducto($idJuego);
if (!$juego) {
    // Juego no encontrado, redirigir o mostrar un mensaje de error
    header("Location: tienda.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pishi Games - Detalles del Juego</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
</head>
<style>
    .contenedorjuegoxd{
        width: 600px;
        margin: 60px auto;
        border: 5px solid red;
        padding: 50px;
        border-radius: 30px;
        text-align: center;
    }
    .imagen{
        margin-top: -50px;
    }

    .agregar-carrito{
        margin-top: 50px;
        margin-left: 400px;
    }
</style>
<body>
    <div class="contenedorjuegoxd">
        <div class="juego-detalle">
            <h2 class="titulo"><?php echo $juego['titulo']; ?></h2>
            <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
            <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
            <p class="precio"><span style="color:#3A84F4">Precio:</span> <?php echo number_format($juego['precio'], 0, '', '.'); ?></p>
            <p class="stock">Stock: <?php echo $juego['stock']; ?></p>
            <div class="butons">
            <form action="detalles_juego.php" method="POST">
                <input type="hidden" name="idJuego" value="<?php echo $juego['idJuego']; ?>">
                <button class="agregar-carrito" name="agregarCarrito" type="submit">Agregar al Carrito</button>
            </form>
            </div>
        </div>
    </div>
</body>

</html>