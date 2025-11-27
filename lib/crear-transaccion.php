<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';

use Transbank\Webpay\WebpayPlus\Transaction;

// ========== NUNCA PROCESA TOKEN AQUÍ ===========
if (isset($_POST['token_ws'])) {
    die("❌ Error: token_ws NO debe recibirse aquí. Este archivo no procesa pagos.");
}

// ===============================================

$id_usuario  = intval($_POST['id_usuario'] ?? 0);
$id_tarjeta  = intval($_POST['id_tarjeta'] ?? 0);
$monto       = intval($_POST['monto'] ?? 0);

if ($id_usuario <= 0 || $id_tarjeta <= 0 || $monto <= 0) {
    die("❌ Datos inválidos.");
}

// Crear transacción Webpay
$apiKey = "579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C";
$commerceCode = "597055555532";

$transaction = Transaction::buildForIntegration($apiKey, $commerceCode);

$buy_order  = "recarga-" . time();
$session_id = "usuario-" . $id_usuario . "-" . time();
$return_url = "http://localhost/app-buses/lib/commit.php";

$response = $transaction->create($buy_order, $session_id, $monto, $return_url);

// Datos de Webpay
$url   = $response->getUrl();
$token = $response->getToken();

// Guardar recarga pendiente
$sql = "INSERT INTO recargas (id_usuario, id_tarjeta, monto, estado)
        VALUES (?, ?, ?, 'pendiente')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id_usuario, $id_tarjeta, $monto);
$stmt->execute();

$_SESSION['id_recarga'] = $stmt->insert_id;

// Redirigir automáticamente a Webpay
?>
<form action="<?= $url ?>" method="POST" id="wp">
    <input type="hidden" name="token_ws" value="<?= $token ?>">
</form>

<script>
document.getElementById('wp').submit();
</script>
