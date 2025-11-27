<?php
require_once __DIR__ . '/lib/consultar-saldo.php';

$saldo = consultarSaldo();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Saldo</title>
</head>
<body>
<p class="parrafo-saldo"><strong>$<?= number_format($saldo, 0, ',', '.') ?></strong></p>

</body>
</html>
