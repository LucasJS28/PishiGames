<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Productos.php";
$productos = new Productos();

/* Revisa que el Puesto sea según los Permisos para entrar a la Página */
if (!isset($_SESSION["Puesto"]) || ($_SESSION["Puesto"] !== "Trabajador" && $_SESSION["Puesto"] !== "Administrador")) {
    header("Location:../index.php");
    exit();
}

if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    $ruta_imagen = 'imagenesjuegos/' . $imagen;
    $ruta_destino = realpath('../') . '/' . $ruta_imagen;
    move_uploaded_file($imagen_temporal, $ruta_destino);

    $agregado = $productos->agregarProductos($titulo, $descripcion, $precio, $stock, $ruta_imagen);
    if ($agregado) {
        echo "<div id='alerta' class='AlertaBuena'>El Producto se Agregó Correctamente</div>";
    } else {
        echo "<div id='alerta' class='AlertaMala'>Ha ocurrido un error al agregar el producto.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
</head>

<body>
    <div class="container">
        <h1 class="heading">Agregar Productos</h1>
        <form action="panelTrabajador.php" method="post" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="titulo" class="form-label">Titulo:</label>
                <input type="text" name="titulo" id="titulo" placeholder="Ingrese el Titulo del Juego..." class="form-input">
            </div>
            <div class="form-group">
                <label for="descripcion" class="form-label">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la Descripcion del Juego..." class="form-input">
            </div>
            <div class="form-group">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" name="precio" id="precio" placeholder="Ingrese el Precio del Juego..." class="form-input">
            </div>
            <div class="form-group">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" id="stock" placeholder="Ingrese el Stock del Juego..." class="form-input">
            </div>
            <div class="form-group">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" id="imagenes" name="imagenes" required class="form-input">
                <img id="imagen-preview" src="" alt="Preview Image" style="max-width: 200px; display: none;">
            </div>
            <input type="submit" value="Publicar Videojuego" class="submit-button">
        </form>
    </div>
    <script>
        document.getElementById('imagenes').addEventListener('change', function(event) { //Escucha el Cambio al seleccionar una imagen
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagen-preview').src = e.target.result; //le asigna la ruta de la imagen en el src a el ancla creado
                    document.getElementById('imagen-preview').style.display = 'block'; //Le cambia el displayu para hacerlo visible
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
</body>

</html>