<?php
session_start();

// Si no hay sesión o el rol no es "pasajeros", redirige al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'pasajeros') {
    header("Location: ../index.php");
    exit();
}

// Mostrar el nombre del usuario logueado
echo "<h2>Bienvenido, " . htmlspecialchars($_SESSION['nombre']) . " (pasajero)</h2>";
echo "<a href='lib/cerrar_sesion.php'>Cerrar sesión</a>";
?>



