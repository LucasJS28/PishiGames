<?php 
require_once 'conexion.php';

class Productos {
    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion(); // Crear una instancia de la clase de conexión existente
    }

    public function realizarPedido($idUsuario, $fechaPedido, $estado, $detalles, $total) {
        $sql = "INSERT INTO pedidos (idUsuario, fechaPedido, estado, detalles, total) VALUES (:idUsuario, :fechaPedido, :estado, :detalles, :total)";
        $consulta = $this->conexion->prepare($sql);
        $consulta->bindParam(':idUsuario', $idUsuario);
        $consulta->bindParam(':fechaPedido', $fechaPedido);
        $consulta->bindParam(':estado', $estado);
        $consulta->bindParam(':detalles', $detalles);
        $consulta->bindParam(':total', $total);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    }
}
?>