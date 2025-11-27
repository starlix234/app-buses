<?php
require_once __DIR__ . '/lib/historial.php';

$historial = obtenerHistorial();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Movimientos</title>
    <link rel="stylesheet" href="assets/js/estilos.css">
</head>
<body>

<h1>Historial de Movimientos</h1>

<?php if (empty($historial)): ?>

    <p style="color:white;">No hay movimientos registrados.</p>

<?php else: ?>

    <div>
        <?php foreach ($historial as $mov): ?>
            
            <div class="hist-item">

                <strong><?= ucfirst($mov['tipo']) ?></strong>
                <br>

                $<?= number_format($mov['monto'], 0, ',', '.') ?>
                <br>

                <small><?= $mov['descripcion'] ?></small>
                <br>

                <small><?= $mov['fecha'] ?></small>

            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>


</body>
</html>
