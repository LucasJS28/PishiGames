<?php
session_start();

if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    echo "<script>alert('Recuerde Iniciar Sesion para Efectuar el Pago');</script>";
    exit();
}

if (isset($_GET['total'])) {
    $total = $_GET['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>






