<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/conexion.php';

use Transbank\Webpay\WebpayPlus\Transaction;

/* ========================================================
   1) RECIBIR TOKEN_WS DESDE WEBPAY (GET o POST)
   ======================================================== */

$token_ws = $_POST['token_ws'] ?? $_GET['token_ws'] ?? null;

if (!$token_ws) {
    die("<h2 style='color:red;'>❌ No llegó token_ws desde Webpay.</h2>");
}


/* ========================================================
   2) CONFIGURAR TRANSBANK
   ======================================================== */
$apiKey = "579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C";
$commerceCode = "597055555532";

$transaction = Transaction::buildForIntegration($apiKey, $commerceCode);


/* ========================================================
   3) EJECUTAR COMMIT
   ======================================================== */

try {
    $response = $transaction->commit($token_ws);
} catch (Exception $e) {
    die("<h2 style='color:red;'>❌ Error en commit(): " . $e->getMessage() . "</h2>");
}


/* ========================================================
   4) LEER DATOS RETORNADOS POR WEBPAY
   ======================================================== */

$id_recarga = $_SESSION['id_recarga'] ?? 0;

$buy_order        = $response->getBuyOrder();
$session_id       = $response->getSessionId();
$amount           = $response->getAmount();
$response_code    = $response->getResponseCode();   // 0 = aprobado
$authorization    = $response->getAuthorizationCode();
$payment_type     = $response->getPaymentTypeCode();
$installments     = $response->getInstallmentsNumber();
$transaction_date = $response->getTransactionDate();

$status_pago = ($response_code === 0) ? "pagado" : "rechazado";


/* ========================================================
   5) GUARDAR TRANSACCIÓN EN BD
   ======================================================== */

$sql = "INSERT INTO transacciones_webpay
        (id_recarga, token_ws, buy_order, session_id, amount, response_code, 
        authorization_code, payment_type, installments, transaction_date, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "isssiiissss",
    $id_recarga,
    $token_ws,
    $buy_order,
    $session_id,
    $amount,
    $response_code,
    $authorization,
    $payment_type,
    $installments,
    $transaction_date,
    $status_pago
);

$stmt->execute();


/* ========================================================
   6) ACTUALIZAR LA RECARGA EN LA BD
   ======================================================== */

$sql2 = "UPDATE recargas SET estado = ? WHERE id_recarga= ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("si", $status_pago, $id_recarga);
$stmt2->execute();


/* ========================================================
   7) MOSTRAR RESULTADOS AL USUARIO
   ======================================================== */
/*
if ($status_pago === "pagado") {
    echo "<h1 style='color:green;'>✔ Pago exitoso</h1>";
    echo "<p>Tu recarga fue procesada correctamente.</p>";
} else {
    echo "<h1 style='color:red;'>❌ Pago rechazado</h1>";
    echo "<p>El banco no autorizó la transacción.</p>";
}*/

if ($status_pago === "pagado") {

    // Registrar recarga como movimiento
    $sql3 = "INSERT INTO movimientos (id_usuario, tipo, monto, descripcion)
             VALUES (?, 'recarga', ?, 'Recarga desde Webpay')";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("ii", $_SESSION['id_usuario'], $amount);
    $stmt3->execute();
}

// Mostrar detalles (solo debug, puedes ocultarlo luego)
echo "<pre>";
print_r($response);
echo "</pre>";

?>
