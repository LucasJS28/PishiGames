<?php
    // Verificar si el usuario ha iniciado sesión y tiene un rol asignado
    if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['Puesto'])) {
        // Si no ha iniciado sesión, redirigir al formulario de inicio de sesión
        header("Location:../index.php");
        exit();
    }

    // Obtener el ID_Rol del usuario
    $rol = $_SESSION['Puesto'];

    // Mostrar el menú en función del ID_Rol
    function mostrar_menu($rol) {
        if ($rol == "Administrador") {  
            echo '
                <ul>
                    <a href="#"><img id="pishiLogo" src="../iconos/iconpishi" alt=""></a>
                    <li><a href="panelAdministrador.php">Agregar trabajador</a></li>
                    <li><a href="panelTrabajador.php">Agregar producto</a></li>
                    <li><a href="../cerrarsesion.php">Cerrar Sesion</a></li>
                </ul>
            ';
        } elseif ($rol == "Trabajador") {  
            echo '
                <ul>
                <a href="#"><img id="pishiLogo" src="../iconos/iconpishi" alt=""></a>
                    <li><a href="panelTrabajador.php">Agregar producto</a></li>
                    <li><a href="revisarPedidos.php">Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php">Cerrar Sesion</a></li>
                </ul>
            ';
        } elseif ($rol == "Jefe") {  
            echo '
                <ul>
                <a href="#"><img id="pishiLogo" src="../iconos/iconpishi" alt=""></a>
                    <li><a href="panelJefe.php">Ver Precios</a></li>
                    <li><a href="revisarPedidos.php">Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php">Cerrar Sesion</a></li>
                </ul>
            ';
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Navegación</title>
    <script src="../scripts/scripts.js" defer></script>
    <link rel="stylesheet" href="../estilos/styles2.css">
    <link rel="stylesheet" href="../estilos/stylesAdm.css">
</head>
<body>
    <!-- Llama la funcion que hace aparecer el Nav segun el Rol -->
    <div class="navbar">
        <?php mostrar_menu($_SESSION['Puesto']); ?> <!-- Entrega el valor de la session puesto para entregar un nav u otro -->
    </div>
</body>
</html>
