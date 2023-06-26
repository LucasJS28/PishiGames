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
                    <li><a href="panelAdministrador.php"><i class="fas fa-user-plus"></i> Agregar trabajador</a></li>
                    <li><a href="panelTrabajador.php"><i class="fas fa-plus"></i> Agregar producto</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Administrador</span></li>
                </ul>
            ';
        } elseif ($rol == "Trabajador") {
            echo '
                <ul>
                    <a href="#"><img id="pishiLogo" src="../iconos/iconpishi" alt=""></a>
                    <li><a href="panelTrabajador.php"><i class="fas fa-plus"></i> Agregar producto</a></li>
                    <li><a href="revisarPedidos.php"><i class="fas fa-clipboard-list"></i> Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Trabajador</span></li>
                </ul>
            ';
        } elseif ($rol == "Jefe") {
            echo '
                <ul>
                    <a href="#"><img id="pishiLogo" src="../iconos/iconpishi" alt=""></a>
                    <li><a href="panelJefe.php"><i class="fas fa-money-bill-wave"></i> Ver Precios</a></li>
                    <li><a href="revisarPedidos.php"><i class="fas fa-clipboard-list"></i> Ver Pedidos</a></li>
                    <li><a href="../cerrarsesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    <li class="rango">Bienvenido: <span>Jefe</span></li>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">

</head>
<body>
    <!-- Llama la funcion que hace aparecer el Nav segun el Rol -->
    <div class="navbar">
        <?php mostrar_menu($_SESSION['Puesto']); ?> <!-- Entrega el valor de la session puesto para entregar un nav u otro -->
    </div>
</body>
</html>
