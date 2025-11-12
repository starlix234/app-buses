<?php
$usuario = "root";
$password = ""; 
$server = "localhost"; 
$base = "bus";

// Crear conexión
$conn= new mysqli($server, $usuario, $password, $base);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    // Opcional: mensaje si quieres confirmar que conecta bien
    // echo "Conexión exitosa a la base de datos.";
}
?>
