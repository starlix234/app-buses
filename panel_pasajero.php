<?php
session_start();

// Verificar sesión y rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'pasajeros') {
    header("Location: ../index.php");
    exit();
}

$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasajero</title>

    <link rel="stylesheet" href="assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="assets/js/menu.js" defer></script>
</head>
<body>

<?php include("menu.php")?>

<!-- CONTENIDO REAL -->
<div class="content">
    <h2>Bienvenido, <?php echo htmlspecialchars($nombre); ?> (pasajero)</h2>
</div>

<?php include("pie.php"); ?>

</body>
</html>
