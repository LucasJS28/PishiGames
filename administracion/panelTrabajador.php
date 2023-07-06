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

$juegos = $productos->mostrarTodosProductosAsc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
    <script src="../scripts/scriptsValidaciones.js"></script>
</head>
<style>
    .contenedor{
        float: left;
        width: 40%;
        margin-left: 50px;
        height: 70%;
    }
    .contenedor-tabla{
        top: 90px;
        right: 20px;
        width: 40%;
        margin-right: 50px;
        overflow-y: scroll;
        height: 500px;
    }
</style>
<body>
    <div class="contenedor">
        <h1 class="titulo">Agregar Productos</h1>
        <form action="panelTrabajador.php" method="post" enctype="multipart/form-data" class="product-form" onsubmit="return validarFormularioJuegos()">
            <div class="formularios">
                <label for="titulo" class="formularios-label">Titulo:</label>
                <input type="text" name="titulo" id="titulo" placeholder="Ingrese el Titulo del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="descripcion" class="formularios-label">Descripcion:</label>
                <input type="text" name="descripcion" id="descripcion" placeholder="Ingrese la Descripcion del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="precio" class="formularios-label">Precio:</label>
                <input type="number" name="precio" id="precio" placeholder="Ingrese el Precio del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="stock" class="formularios-label">Stock:</label>
                <input type="number" name="stock" id="stock" placeholder="Ingrese el Stock del Juego..." class="formulario-input" required>
            </div>
            <div class="formularios">
                <label for="imagen" class="formularios-label">Imagen:</label>
                <input type="file" id="imagen" name="imagen" required class="formulario-input">
                <img id="imagen-preview" src="" alt="Preview Image" style="max-width: 200px; display: none;">
            </div>
            <input type="submit" value="Publicar Videojuego" class="submit-button">
        </form>
    </div>
    
    <div class="contenedor-tabla">
        <h1 class="titulo">Listado de Juegos</h1>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Pedido</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese ID del Juego a Buscar">
        </div>
        <!-- Agrega el código para mostrar los juegos en una tabla -->
        <?php if (!empty($juegos)) { ?>
            <table class="tabla-principal">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Precio</th>
                </tr>
                <?php foreach ($juegos as $juego) { ?>
                    <tr>
                        <td><?php echo $juego['idJuego']; ?></td>
                        <td><img src="../<?php echo $juego['imagen']; ?>" width="150px" alt="Imagen del Juego"></td>
                        <td><?php echo $juego['titulo']; ?></td>
                        <td><?php echo $juego['stock']; ?></td>
                        <td><?php echo number_format($juego['precio'], 0, '', '.'); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?>
            <p class="no-pedidos">No se encontraron juegos.</p>
        <?php } ?>
    </div>
    <script>
        document.getElementById('imagen').addEventListener('change', function(event) { //Escucha el Cambio al seleccionar una imagen
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagen-preview').src = e.target.result; //le asigna la ruta de la imagen en el src a el ancla creado
                    document.getElementById('imagen-preview').style.display = 'block'; //Le cambia el display para hacerlo visible
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
</body>

</html>