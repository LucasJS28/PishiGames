<?php
session_start();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Trabajador" && $permiso !== "Administrador") {
    header("Location: index.php");
    exit();
}
require_once 'conexiones/crudProductos.php';
if (isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    $ruta_imagen = 'imagenesJuegos/' . $imagen;
    move_uploaded_file($imagen_temporal, $ruta_imagen);
    
    // Crear una instancia de la clase Productos y agregar el producto
    $productos = new Productos();
    $agregado = $productos->agregarProductos($titulo, $descripcion, $precio, $stock, $ruta_imagen);
    
    if ($agregado) {
        echo 'El producto se ha agregado correctamente.';
    } else {
        echo 'Ha ocurrido un error al agregar el producto.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        Bienvenido: <?php echo $permiso;?> <a href="cerrarsesion.php">Cerrar Sesion</a><br>
        <?php 
            if ($permiso == "Administrador") {
                echo "<a href='panelAdministrador.php'>Volver al Panel de Administracion</a>";
            }
        ?>
    </div>
    <h1>Agregar Productos</h1>
    <form action="panelTrabajador.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Titulo:</label><input type="text" name="titulo" id="titulo" placeholder="Ingrese el Titulo del Juego..."><br>
        <label for="descripcion">Descripcion:</label><input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la Descripcion del Juego..."><br>
        <label for="precio">Precio:</label><input type="number" name="precio" id="precio" placeholder="Ingrese el Precio del Juego..."><br>
        <label for="stock">Stock:</label><input type="number" name="stock" id="stock" placeholder="Ingrese el Titulo del Juego..."><br>
        <label for="imagen">Imagen:</label><input type="file" id="imagen" name="imagen" required><br>
        <input type="submit" value="Publicar Videojuego">
    </form>

</body>
</html>