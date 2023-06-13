<?php
session_start();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Trabajador") {
    header("Location: index.php");
    exit();
}


?>