<?php
session_start();
require_once 'conexiones/pedidos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPedido = $_POST['idPedido'];
    $estado = $_POST['estado'];

    // Actualizar el estado del pedido en la base de datos
    $pedidos = new Productos();
    $pedidos->actualizarEstadoPedido($idPedido, $estado);

    // Redirigir a la página de listado de pedidos
    header("Location: revisarPedidos.php");
    exit();
}
?>