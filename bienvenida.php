<?php 
session_start();
require_once 'conexiones/Productos.php';
include 'nav.php';
/* Crea el objeto de tipo producto y llama al metodo para mostrar todos los Productos Baratos */
$productos = new Productos();
$listaJuegos  = $productos->mostrarProductosmasBaratos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pishi Games</title>
    <link rel="stylesheet" href="estilos/style.css">
    <script src="scripts/scripts.js" defer></script>
</head>
<body>
    <!-- Tiulo de la Pagina Principal -->
    <section id="Bienvenida">
        <h1 id="titulo">Pishi Games</h1>
        <h3 id="subtitulo">!!!Estamos para Quedarnos!!! Autor: Lucas Jimenez Sepulveda</h3>
    </section>

    <!-- Video de la Pagina Principal -->
    <div id="VideoPresentacion">
        <video muted controls autoplay loop src="videos/videoPresentacion.mp4"></video>
    </div>
    <h1 id="titulo" style="font-size:25px">!!! Ofertas del Dia de Hoy !!!</h1>
    <ul class="listaJuegos">

    <!-- Muestra los juegos con el precio mas bajo que tengan stock -->
        <?php foreach ($listaJuegos as $juego){ ?>
            <!-- Verifica si hay stock y en caso de no tener le genera la clase juego-sin-stock -->
            <li class="Juegos juego <?php echo ($juego['stock'] == 0) ? 'sin-stock' : ''; ?>">
                <div class="juego-container">
                    <h4 class="titulo"><?php echo $juego['titulo']; ?></h4>
                    <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
                    <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
                    <p class="precio">Precio: <?php echo $juego['precio']; ?></p>
                </div>
            </li>
        <?php } ?>
    </ul>
</body>
</html>