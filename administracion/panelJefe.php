<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Productos.php";
$productos = new Productos();
$listaProductos = $productos->mostrarTodosProductos();

/* Revisa que el Puesto sea segun los Permisos para entrar a la Pagina */
if (!isset($_SESSION["Puesto"])) {
    header("Location:../index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Jefe") {
    header("Location:../index.php");
    exit();
}

$precioAnterior = '';
$stockAnterior = '';
$imagenJuegoSrc = '';

/* Actualiza el precio segun lo recibido en el formulario */
/* Recibe por Separado los diferentes valores Stock o Precio para que no se suban a la vez y remplacen valores de forma equivocada */
if ($_POST) {
    $idJuego = $_POST['juego'];
    if (isset($_POST['actualizar_precio'])) {
        $nuevoPrecio = $_POST['precio_nuevo'];
        $resultadoPrecio = $productos->actualizarProducto($idJuego, $nuevoPrecio);
        if ($resultadoPrecio) {
            echo "<div id='alerta' class='AlertaBuena'>El precio se actualizó correctamente</div>";
        } else {
            echo "<div id='alerta' class='AlertaMala'>Hubo un error al actualizar el precio.</div>";
        }
    }
    if (isset($_POST['actualizar_stock'])) {
        $nuevoStock = $_POST['stock_nuevo'];
        $resultadoStock = $productos->actualizarStock($idJuego, $nuevoStock);
        if ($resultadoStock) {
            echo "<div id='alerta' class='AlertaBuena'>El stock se actualizó correctamente</div>";
        } else {
            echo "<div id='alerta' class='AlertaMala'>Hubo un error al actualizar el stock.</div>";
        }
    }
/* Muestra un Objeto por defecto al iniciar el formulario */
} else {
    if (!empty($listaProductos)) {
        $firstProduct = $listaProductos[0];
        $precioAnterior = $firstProduct['precio'];
        $stockAnterior = $firstProduct['stock'];
        $imagenJuegoSrc = '../' . $firstProduct['imagen'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Juego</title>
    <link rel="stylesheet" href="../estilos/stylesAdm.css"> 
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/scriptsValidaciones.js"></script>
</head>

<body>
    <div class="contenedor">
        <h2 class="titulo">Editar Juego</h2>
        <form method="POST" action="panelJefe.php">
            <div class="formularios">
                <label for="juego" class="formularios-label">Seleccione un juego:</label>
                <select name="juego" id="juego" onchange="fillForms()">
                    <?php
                    foreach ($listaProductos as $producto) {
                        $rutaImagen = "../" . $producto['imagen'];
                        echo '<option value="' . $producto['idJuego'] . '" data-precio="' . $producto['precio'] . '" data-stock="' . $producto['stock'] . '" data-imagen="' . $rutaImagen . '">' . $producto['titulo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <!-- Formulario de Cambio de Stock -->
            <div>
                <h3 class="section-heading">Cambiar Stock</h3>
                <div class="formularios">
                    <label for="stock_anterior" class="formularios-label">Stock anterior:</label>
                    <input type="text" name="stock_anterior" id="stock_anterior" class="formulario-input" value="" readonly>
                </div>
                <div class="formularios">
                    <label for="stock_nuevo" class="formularios-label">Nuevo Stock:</label>
                    <input type="text" name="stock_nuevo" id="stock_nuevo" class="formulario-input">
                </div>
                <div class="formularios">
                    <input type="submit" name="actualizar_stock" value="Actualizar Stock" class="boton-envio">
                </div>
            </div>
            
            <!-- Formulario de Cambio de Precio -->
            <div>
                <h3 class="section-heading">Cambiar Precio</h3>
                <div class="formularios">
                    <label for="precio_anterior" class="formularios-label">Precio anterior:</label>
                    <input type="text" name="precio_anterior" id="precio_anterior" class="formulario-input" value="" readonly>
                </div>
                <div class="formularios">
                    <label for="precio_nuevo" class="formularios-label">Nuevo Precio:</label>
                    <input type="text" name="precio_nuevo" id="precio_nuevo" class="formulario-input">
                </div>
                <div class="formularios">
                    <input type="submit" name="actualizar_precio" value="Actualizar Precio" class="boton-envio">
                </div>
            </div>
        </form>
        <!-- Muestra una imagen del Juego Seleccionado -->
        <div>
            <img id="imagen_juego" src="" alt="Imagen del juego" class="game-image" hidden>
        </div>
    </div>
</body>

</html>