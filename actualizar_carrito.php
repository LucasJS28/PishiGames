<?php
session_start(); // Iniciar sesión (si aún no está iniciada)

// Procesar las acciones de quitar, aumentar y eliminar del carrito
if (isset($_GET['id']) && isset($_GET['action'])) {
    $idJuego = $_GET['id'];
    $action = $_GET['action'];

    if ($action == 'remove') {
        // Restar 1 a la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $_SESSION['carrito'][$idJuego]['cantidad'] -= 1;

            // Eliminar el producto si la cantidad es menor o igual a 0
            if ($_SESSION['carrito'][$idJuego]['cantidad'] <= 0) {
                unset($_SESSION['carrito'][$idJuego]);
            }
        }
    } elseif ($action == 'add') {
        // Sumar 1 a la cantidad del producto en el carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            $_SESSION['carrito'][$idJuego]['cantidad'] += 1;
        }
    } elseif ($action == 'delete') {
        // Eliminar el producto del carrito
        if (isset($_SESSION['carrito'][$idJuego])) {
            unset($_SESSION['carrito'][$idJuego]);
        }
    }

    header('Location: carrito.php'); // Redirigir de vuelta a la página del carrito
    exit();
}
?>
