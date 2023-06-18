<?php 
session_start();
require_once 'conexiones/Productos.php';
include 'nav.php';
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
<body>
    <section id="Bienvenida">
        <h1 id="titulo">Pishi Games</h1>
        <h3 id="subtitulo">!!!Estamos para Quedarnos!!! Autor: Lucas Jimenez Sepulveda</h3>
    </section>
    <div id="VideoPresentacion">
        <video muted controls autoplay src="videos/videoPresentacion.mp4"></video>
    </div>
    <h1 id="titulo" style="font-size:25px">!!! Nuestros Titulos mas Baratos !!!</h1>
    <ul class="listaJuegos">
        <?php foreach ($listaJuegos as $juego){ ?>
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