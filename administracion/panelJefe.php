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


// Actualizar el producto si se ha enviado el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        $id = $_POST['id'];

        if ($accion === 'modificar_precio') {
            $precio = $_POST['precio'];
            $productos->actualizarProducto($id, $precio);
        } elseif ($accion === 'eliminar') {
            $productos->eliminarProducto($id);
        } elseif ($accion === 'modificar_stock') {
            $stock = $_POST['stock'];
            $productos->actualizarStock($id, $stock);
        }

        // Redireccionar a la misma página para actualizar la tabla
        header('Location: panelJefe.php ');
        exit;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Importar jQuery -->
    <script src="../scripts/scriptsValidaciones.js"></script>
    <script src="../scripts/scripts.js"></script>
    <script src="../scripts/ajax.js"></script>
</head>

<body>
    <div class="contenedor-tabla">
        <h1 class="titulo">Modificar Productos</h1>
        <div id="buscador">
            <label for="buscar" id="titulo-buscar">Buscar Pedido</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese el ID del Pedido a buscar">
        </div>
        <table class="tabla-principal">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($listaProductos as $producto) { ?>
                <tr>
                    <td><?php echo $producto['idJuego']; ?></td>
                    <td><?php echo $producto['titulo']; ?></td>
                    <td><img width="150px" style="border: 3px solid red;" id="imgtabla" src="<?php echo "../" . $producto['imagen']; ?>" alt=""></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td>
                        <!-- Formulario para modificar el precio del producto -->
                        <form class="ajax-form" method="POST" action="panelJefe.php">
                            <input type="hidden" name="id" value="<?php echo $producto['idJuego']; ?>">
                            <input class="input-panelJefe" type="number" name="precio" value="<?php echo $producto['precio']; ?>">
                            <input type="hidden" name="accion" value="modificar_precio">
                            <button class="btn-panelJefe" type="submit">Cambiar Precio</button>
                        </form>
                    </td>

                    <td>
                        <!-- Formulario para modificar el stock del producto -->
                        <form class="ajax-form" method="POST" action="panelJefe.php">
                            <input type="hidden" name="id" value="<?php echo $producto['idJuego']; ?>">
                            <input class="input-panelJefe" type="number" name="stock" value="<?php echo $producto['stock']; ?>">
                            <input type="hidden" name="accion" value="modificar_stock">
                            <button class="btn-panelJefe" type="submit">Cambiar Stock</button>
                        </form>
                    </td>
                    <td class="acciones">
                        <!-- Formulario para eliminar el producto -->
                        <form class="ajax-form" method="POST" action="panelJefe.php" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            <input type="hidden" name="id" value="<?php echo $producto['idJuego']; ?>">
                            <input type="hidden" name="accion" value="eliminar">
                            <button type="submit" class="boton-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>

</html>
