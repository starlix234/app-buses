<?php
session_start();
require_once __DIR__ . '/conexion.php';

$id_usuario = $_POST['id_usuario'];
$id_tarjeta = $_POST['id_tarjeta'];
$monto      = $_POST['monto'];

// Obtener los datos de la tarjeta
$sql = "SELECT marca, ultimos_4 FROM tarjetas_tokenizadas WHERE id=? AND id_usuario=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_tarjeta, $id_usuario);
$stmt->execute();
$tarjeta = $stmt->get_result()->fetch_assoc();
?>

<h2>Confirmar Recarga</h2>

<p><strong>Monto:</strong> $<?= number_format($monto, 0, ',', '.') ?></p>
<p><strong>Tarjeta:</strong> <?= strtoupper($tarjeta['marca']) ?> •••• <?= $tarjeta['ultimos_4'] ?></p>

<form action="crear-transaccion.php" method="POST">
    <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
    <input type="hidden" name="id_tarjeta" value="<?= $id_tarjeta ?>">
    <input type="hidden" name="monto" value="<?= $monto ?>">

    <button type="submit">Confirmar pago</button>
</form>
