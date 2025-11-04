<?php
$usuario = "root";
$password = ""; 
$server = "localhost"; 
$base = "bus";

// Crear conexión
$conexion = new mysqli($server, $usuario, $password, $base);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    // Opcional: mensaje si quieres confirmar que conecta bien
    // echo "Conexión exitosa a la base de datos.";
}
?>
