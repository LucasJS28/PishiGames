<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Productos.php";
$productos = new Productos();

/* Revisa que el Puesto sea segun los Permisos para entrar a la Pagina */
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Trabajador" && $permiso !== "Administrador") {
    header("Location:../index.php");
    exit();
}

/* Revisa que los Formularios esten llenos para poder realizar la insersion en la Base de Datos */
if (isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['precio']) && isset($_POST['stock']) && isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $imagen = $_FILES['imagen']['name'];
    $imagen_temporal = $_FILES['imagen']['tmp_name'];
    /* Guarda la Ruta de la imagen en la Base de Datos */
    $ruta_imagen = 'imagenesjuegos/' . $imagen;
    //En este código, $ruta_destino obtiene la ruta absoluta real del directorio raíz del sitio utilizando la función realpath('../'). Luego, se concatena con $ruta_imagen 
    $ruta_destino = realpath('../') . '/' . $ruta_imagen;
    move_uploaded_file($imagen_temporal, $ruta_destino);
    
    // Crear una instancia de la clase Productos y agregar el producto
    $agregado = $productos->agregarProductos($titulo, $descripcion, $precio, $stock, $ruta_imagen);
    if ($agregado) {
        echo "<div id='alerta' class='AlertaBuena'>El Producto se Agrego Correctamente</div>";
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
                <input type="file" id="imagen" name="imagen" required class="form-input">
                <img id="imagen-preview" src="" alt="Preview Image" style="max-width: 200px; display: none;">
            </div>
            <input type="submit" value="Publicar Videojuego" class="submit-button">
        </form>
    </div>

    <!-- Muestra la imagen al momento de ser seleccionado -->
    <script>
        // Escucha el evento 'change' del elemento 'imagen'
        document.getElementById('imagen').addEventListener('change', function(event) {
            var input = event.target;
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                // Cuando se complete la lectura del archivo
                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagen-preview');
                    
                    // Establece la fuente de la imagen de vista previa
                    imagePreview.src = e.target.result;
                    
                    // Muestra la imagen de vista previa
                    imagePreview.style.display = 'block';
                }
                
                // Lee el archivo como una URL de datos
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
</body>

</html>
