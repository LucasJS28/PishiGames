<?php
require_once 'conexiones/Productos.php';
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <nav>
        <a href="bienvenida.php"><img src="iconos/iconpishi" alt=""></a>
        <ul class="lista">
            <li><img class="icono" src="iconos/logoinicio.png" alt=""> <a href="bienvenida.php">Inicio</a></li>
            <li><img class="icono" src="iconos/logotienda.png" alt=""> <a href="tienda.php">Tienda</a></li>
            <li><img class="icono" src="iconos/logocarro.png" alt=""> <a href="carrito.php">Carrito</a></li>
            <li><img class="icono" src="iconos/logocontacto.png" alt=""><a href="contactos.php">Contacto</a></li>
            <?php if (!$idUsuario) : ?>
                <li><img class="icono" src="iconos/logoiniciosesion.png" alt=""><a href="index.php">Iniciar Sesion</a></li>
                <li><img class="icono" src="iconos/logoregistro.png" alt=""><a href="registroUsuarios.php">Registrarse</a></li>
            <?php else : ?>
                <li><img class="icono" src="iconos/logocerrarsesion.png" alt=""><a href="cerrarsesion.php">Cerrar Sesion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>

</html>