<?php
session_start();
require_once __DIR__ . '/lib/conexion.php';

// Debe haber usuario logueado
if(!isset($_SESSION['id_usuario'])){
    die("No estás logueado.");
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener las tarjetas tokenizadas de este usuario
$sql = "SELECT id, ultimos_4, marca FROM tarjetas_tokenizadas WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Recargar tarjeta</title>
</head>
<body>

<h2>💳 Recargar tarjeta</h2>

<form action="lib/confirmar-pago.php" method="POST">
    
    <label>Monto a recargar:</label>
    <input type="number" name="monto" required min="100">

    <br><br>

    <label>Selecciona una tarjeta:</label>
    <select name="id_tarjeta" required>
        <?php while($row = $result->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>">
                <?= strtoupper($row['marca']) ?> •••• <?= $row['ultimos_4'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

    <br><br>
    <button type="submit">Recargar ahora</button>
</form>

</body>
</html>
