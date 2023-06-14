<?php 
    require_once 'conexion.php';
    class Productos {
        private $conexion;
        
        public function __construct() {
            $this->conexion = new Conexion(); // Crear una instancia de la clase de conexión existente
        }

        public function agregarProductos($titulo, $descripcion, $precio, $stock, $imagen) {
            try {
                $sql = "INSERT INTO videojuego (titulo, descripcion, precio, stock, imagen) VALUES (:titulo, :descripcion, :precio, :stock, :imagen)";
                $consulta = $this->conexion->prepare($sql);
                $consulta->bindParam(':titulo', $titulo);
                $consulta->bindParam(':descripcion', $descripcion);
                $consulta->bindParam(':precio', $precio);
                $consulta->bindParam(':stock', $stock);
                $consulta->bindParam(':imagen', $imagen);
                $consulta->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    

        public function mostrarProductos(){
            $sql = "SELECT * FROM videojuego";
            $consulta = $this->conexion->prepare($sql); 
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function eliminarProducto(){


        }
        public function obtenerProducto($id) {
            $sql = "SELECT * FROM videojuego WHERE idJuego = :id";
            $consulta = $this->conexion->prepare($sql);
            $consulta->bindParam(':id', $id);
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public function actualizarProducto($id, $precio) {
            try {
                $sql = "UPDATE videojuego SET precio = :precio WHERE idJuego = :id";
                $consulta = $this->conexion->prepare($sql);
                $consulta->bindParam(':id', $id);
                $consulta->bindParam(':precio', $precio);
                $consulta->execute();
                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
    }
?>