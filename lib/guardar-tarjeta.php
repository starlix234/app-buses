<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Transbank\Webpay\WebpayPlus\Transaction;

// Credenciales de integración
$apiKey = "579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C";
$commerceCode = "597055555532";

// Crear objeto Transaction en modo integración
$transaction = Transaction::buildForIntegration($apiKey, $commerceCode);

// Datos del formulario
$id_usuario  = $_POST['id_usuario'];      // 👈 VIENE DESDE EL FORM
$card_number = $_POST['card_number'];
$expiry      = $_POST['expiry'];
$cvv         = $_POST['cvv'];

$token_fake = "tok_" . substr(md5(time()), 0, 16);
$ultimos4   = substr($card_number, -4);

// Mostrar en pantalla
echo "<h2>Tarjeta guardada exitosamente</h2>";
echo "Token generado: $token_fake<br>";
echo "Últimos 4: $ultimos4<br>";


// =============================================================
//  🔥 GUARDAR EN LA BASE DE DATOS ($conn)
// =============================================================
require_once __DIR__ . '/conexion.php';

try {

    $sql = "INSERT INTO tarjetas_tokenizadas
            (id_usuario, token_tarjeta, ultimos_4, tipo_tarjeta, marca)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $tipo_tarjeta  = 'credito';
    $marca_tarjeta = 'visa';

    $stmt->bind_param(
        "issss",
        $id_usuario,
        $token_fake,
        $ultimos4,
        $tipo_tarjeta,
        $marca_tarjeta
    );

    $stmt->execute();

    echo "<br><strong>✔ Tarjeta guardada en la base de datos.</strong>";

} catch (Exception $e) {
    echo "<br>Error al guardar en la BD: " . $e->getMessage();
}
?>
