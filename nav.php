<?php  
require_once 'conexiones/crudProductos.php';
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
        <a href="tienda.php"><img src="iconos/iconpishi" alt=""></a>
        <ul class="lista">
            <li><a href="tienda.php">Inicio</a></li>
            <li><a href="carrito.php">🛒 Carrito</a></li>
            <li><a href="contactos.php">Contacto</a></li>
            <?php if (!$idUsuario) : ?>
                <li><a href="index.php">Iniciar Sesion</a></li>
                <li><a href="registroUsuarios.php">Registrarse</a></li>
            <?php else : ?>
                <li><a href="cerrarsesion.php">Cerrar Sesion</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>