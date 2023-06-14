<?php
session_start();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Usuario") {
    header("Location: index.php");
    exit();
}

require_once 'conexiones/crudProductos.php';
// Crear una instancia de la clase Productos
$productos = new Productos();

// Obtener la lista de juegos agregados
$listaJuegos = $productos->mostrarProductos();
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
    <a href="cerrarsesion.php">Cerrar Sesion</a>
    <h2>Bienvenido a la Tienda de PishiGames</h2>
    <h3>Juegos disponibles:</h3>
    <ul class="listaJuegos">
        <?php foreach ($listaJuegos as $juego) : ?>
            <li class="Juegos">
                <h4 class="titulo"><?php echo $juego['titulo']; ?></h4>
                <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
                <p class="precio">Precio: <?php echo $juego['precio']; ?></p>
                <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
                <a class="boton-agregar" href="#">Agregar al Carro</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>