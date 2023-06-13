<?php 
    class Conexion extends PDO {
        private $usuario = "root";
        private $contra = ""; 
        
        public function __construct(){
            try {
                parent::__construct("mysql:dbname=empresa;host=localhost;charset=utf8", $this->usuario, $this->contra);
            } catch(PDOException $e) {
                echo("Error: " . $e->getMessage());
                exit;
            }
        }
        
        public function login($correoUsuario, $passUsuario) {
            $sql = "SELECT * FROM usuarios WHERE correoUsuario = :correoUsuario AND passUsuario = :passUsuario";
            $consulta = $this->prepare($sql);
            $consulta->bindParam(':correoUsuario', $correoUsuario);
            $consulta->bindParam(':passUsuario', $passUsuario);
            $consulta->execute();
            $encontrado = $consulta->rowCount();
            
            if ($encontrado) {
                // Obtener el ID_Rol del usuario
                $row = $consulta->fetch(PDO::FETCH_ASSOC);
                $idRol = $row['ID_Rol'];
                return $idRol; // Devuelve el ID_Rol si las credenciales son correctas
            } else {
                return false; // Si las credenciales son incorrectas devuelve false
            }
        }
    }
?>