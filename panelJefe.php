<?php
session_start();
require_once 'conexiones/crudProductos.php';

if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Jefe") {
    header("Location: index.php");
    exit();
}

$productos = new Productos();

if ($_POST) {
    $idJuego = $_POST['juego'];
    $nuevoPrecio = $_POST['precio_nuevo'];
    
    $resultado = $productos->actualizarProducto($idJuego, $nuevoPrecio);

    if ($resultado) {
        echo "El precio se actualizó correctamente.";
    } else {
        echo "Hubo un error al actualizar el precio.";
    }
}
$productos = new Productos();
$listaProductos = $productos->mostrarProductos();
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
        Bienvenido: <?php echo $permiso; ?> <a href="cerrarsesion.php">Cerrar Sesion</a>
    </div>

    <h2>Editar Juego</h2>

    <form method="POST" action="panelJefe.php">
        <label for="juego">Seleccione un juego:</label>
        <select name="juego" id="juego">
            <?php
            foreach ($listaProductos as $producto) {
                echo '<option value="' . $producto['idJuego'] . '" data-precio="' . $producto['precio'] . '" data-imagen="' . $producto['imagen'] . '">' . $producto['titulo'] . '</option>';
            }
            ?>
        </select>
        <br><br>
        <label for="precio_anterior">Precio anterior:</label>
        <input type="text" name="precio_anterior" id="precio_anterior" disabled>
        <br><br>
        <label for="precio_nuevo">Nuevo Precio:</label>
        <input type="text" name="precio_nuevo" id="precio_nuevo">
        <br><br>
        <input type="submit" value="Actualizar">
    </form>
            
    <img id="imagen_juego" src="" alt="Imagen del juego" width="200" hidden>

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