<?php
session_start();
if (!isset($_SESSION["Puesto"])) {
    header("Location: index.php");
    exit();
}
$permiso = $_SESSION["Puesto"];
if ($permiso !== "Jefe") {
    header("Location: index.php");
    exit();
}


?>