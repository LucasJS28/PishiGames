<?php
session_start();
include 'navAdministracion.php';
require_once "../conexiones/Productos.php";
$productos = new Productos();
$listaProductos = $productos->mostrarProductos();

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
$imagenJuegoSrc = '';
if ($_POST) {
    $idJuego = $_POST['juego'];
    $nuevoPrecio = $_POST['precio_nuevo'];

    $resultado = $productos->actualizarProducto($idJuego, $nuevoPrecio);

    if ($resultado) {
        echo "<div id='alerta' class='AlertaBuena'>El precio se actualizó correctamente</div>";
    } else {
        echo "<div id='alerta' class='AlertaMala'>Hubo un error al actualizar el precio.</div>";
    }
} else {
    // Set default values for the form
    if (!empty($listaProductos)) {
        $firstProduct = $listaProductos[0];
        $precioAnterior = $firstProduct['precio'];
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
</head>

<body>
    <div class="container1">
        <h2 class="heading">Editar Juego</h2>

        <form method="POST" action="panelJefe.php" class="edit-form">
            <div class="form-group">
                <label for="juego" class="form-label">Seleccione un juego:</label>
                <select name="juego" id="juego" class="form-select">
                    <?php
                    foreach ($listaProductos as $producto) {
                        $rutaImagen = "../" . $producto['imagen'];
                        echo '<option value="' . $producto['idJuego'] . '" data-precio="' . $producto['precio'] . '" data-imagen="' . $rutaImagen . '">' . $producto['titulo'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="precio_anterior" class="form-label">Precio anterior:</label>
                <input type="text" name="precio_anterior" id="precio_anterior" class="form-input" value="<?php echo $precioAnterior; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="precio_nuevo" class="form-label">Nuevo Precio:</label>
                <input type="text" name="precio_nuevo" id="precio_nuevo" class="form-input">
            </div>
            <div class="form-group">
                <input type="submit" value="Actualizar" class="submit-button">
            </div>
        </form>

        <img id="imagen_juego" src="<?php echo $imagenJuegoSrc; ?>" alt="Imagen del juego" class="game-image" hidden>
    </div>

    <script>
        document.getElementById('juego').addEventListener('change', function() {
            var select = this;
            var selectedOption = select.options[select.selectedIndex];
            var precioAnteriorInput = document.getElementById('precio_anterior');
            var imagenJuego = document.getElementById('imagen_juego');

            precioAnteriorInput.value = selectedOption.dataset.precio;
            imagenJuego.src = selectedOption.dataset.imagen;
            imagenJuego.removeAttribute('hidden');
        });
    </script>
</body>

</html>
