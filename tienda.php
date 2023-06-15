<?php
session_start();
include 'nav.php';  
require_once 'conexiones/crudProductos.php';

// Crear una instancia de la clase Productos
$productos = new Productos();
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

// Obtener la lista de juegos agregados
$listaJuegos = $productos->mostrarProductos();

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
    if (array_key_exists($idJuego, $carrito)) {
        $carrito[$idJuego]['cantidad']++; // Incrementar la cantidad si ya está en el carrito
    } else {
        // Obtener los detalles del producto según el ID
        $juego = $productos->obtenerProducto($idJuego);

        // Verificar si se encontró el producto
        if ($juego) {
            $carrito[$idJuego] = array(
                'titulo' => $juego['titulo'],
                'descripcion' => $juego['descripcion'],
                'imagen' => $juego['imagen'],
                'precio' => $juego['precio'],
                'cantidad' => 1
            );
        }
    }

    // Guardar el carrito en la sesión
    $_SESSION['carrito'] = $carrito;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
    <h2 style="text-align: center;">Bienvenido a la Tienda de PishiGames</h2>
    <h3 style="text-align: center;">Juegos disponibles</h3>
    <ul class="listaJuegos">
        <?php foreach ($listaJuegos as $juego) : ?>
            <li class="Juegos">
                <div class="juego-container">
                    <h4 class="titulo"><?php echo $juego['titulo']; ?></h4>
                    <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
                    <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
                    <p class="precio">Precio: <?php echo $juego['precio']; ?></p>
                    <form action="" method="post">
                        <input type="hidden" name="idJuego" value="<?php echo $juego['idJuego']; ?>">
                        <input type="submit" name="agregarCarrito" value="Agregar al Carrito">
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>