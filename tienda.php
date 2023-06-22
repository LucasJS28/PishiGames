    <?php
    session_start();
    include_once 'nav.php';
    require_once 'conexiones/Productos.php';

    // Crear una instancia de la clase Productos
    $productos = new Productos();
    $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

    // Obtener la lista de juegos agregados
    $listaJuegos = $productos->mostrarProductos();
    $listaJuegosSinStock = $productos->mostrarProductosSinStock();

    // Verificar si se ha agregado algún producto al carrito
    if (isset($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
    } else {
        $carrito = array(); // Crear un carrito vacío
    }

    // Verificar si se ha enviado el formulario de agregar al carrito
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregarCarrito'])) {
        $idJuego = $_POST['idJuego'];

        // Verificar si el juego ya está en el carrito
        if (array_key_exists($idJuego, $carrito)) {
            // Verificar si hay suficiente stock antes de incrementar la cantidad
            if ($productos->verificarStock($idJuego, $carrito[$idJuego]['cantidad'] + 1)) {
                $carrito[$idJuego]['cantidad']++; // Incrementar la cantidad si hay suficiente stock
                echo "<div id='alerta' class='AlertaBuena'>Se añadió una nueva copia al Carro. Cantidad: " . $carrito[$idJuego]['cantidad'] . "</div>";
            } else {
                echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
            }
        } else {
            // Obtener los detalles del producto según el ID
            $juego = $productos->obtenerProducto($idJuego);
            
            // Verificar si se encontró el producto
            if ($juego) {
                // Verificar si hay suficiente stock antes de agregar el producto al carrito
                if ($productos->verificarStock($idJuego, 1)) {
                    $carrito[$idJuego] = array(
                        'titulo' => $juego['titulo'],
                        'descripcion' => $juego['descripcion'],
                        'imagen' => $juego['imagen'],
                        'precio' => $juego['precio'],
                        'cantidad' => 1
                    );
                    echo "<div id='alerta' class='AlertaBuena'>Se añadió al Carrito Cantidad:1</div>";
                } else {
                    echo "<div id='alerta' class='AlertaMala'>No hay suficiente stock</div>";
                }
            }
        }
        // Guardar el carrito en la sesión
        $_SESSION['carrito'] = $carrito;
        exit; // Detener la ejecución del resto del código para evitar recargar la página completa
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pishi Games</title>
        <link rel="stylesheet" href="estilos/style.css">
        <script src="scripts/scripts.js" defer></script>
    </head>

    <body>
        <div id="contenedorBuscar">
            <label for="buscar">Buscar Juego</label>
            <input type="search" name="buscar" id="buscar" placeholder="Ingrese el Nombre del Juego a buscar">
        </div>
        <ul class="listaJuegos">
            <?php foreach ($listaJuegos as $juego) { ?>
                <li class="Juegos juego <?php echo ($juego['stock'] == 0) ? 'sin-stock' : ''; ?>">
                    <div class="juego-container">
                        <h4 class="titulo"><?php echo $juego['titulo']; ?></h4>
                        <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
                        <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
                        <p class="precio">Precio: <?php echo $juego['precio']; ?></p>
                        <p class="stock">Stock: <?php echo $juego['stock']; ?></p>
                        <button class="agregar-carrito" data-id="<?php echo $juego['idJuego']; ?>">Agregar al Carrito</button>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <h2 id="titulosinStock">Juegos sin Stock</h2>
        <ul class="listaJuegos">
            <?php foreach ($listaJuegosSinStock as $juego) { ?>
                <li class="Juegos juego <?php echo ($juego['stock'] == 0) ? 'sin-stock' : ''; ?>">
                    <div class="juego-container">
                        <h4 class="titulo"><?php echo $juego['titulo']; ?></h4>
                        <p class="descripcion"><?php echo $juego['descripcion']; ?></p>
                        <img class="imagen" src="<?php echo $juego['imagen']; ?>" alt="Imagen del juego">
                        <p class="precio">Precio: <?php echo $juego['precio']; ?></p>
                        <p class="stock">Stock: 0</p>
                        <button class="agregar-carrito" data-id="<?php echo $juego['idJuego']; ?>">Producto sin Stock</button>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div id="alerta" class="Alerta"></div> <!-- Elemento para mostrar los mensajes -->
    </body>

    </html>