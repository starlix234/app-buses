<?php
session_start();
if ($_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
echo "<h2>Bienvenido, " . $_SESSION['nombre'] . " (Administrador)</h2>";
echo "<a href='lib/cerrar_sesion.php'>Cerrar sesión</a>";
?>
