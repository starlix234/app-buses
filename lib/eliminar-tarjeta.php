<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    die("Acceso denegado.");
}

$id_tarjeta = $_GET['id'] ?? null;
$id_usuario = $_SESSION['id_usuario'];

if (!$id_tarjeta) {
    die("ID de tarjeta no válido.");
}

/* 1) Verificar que la tarjeta pertenece al usuario */
$sql_check = "SELECT * FROM tarjetas_tokenizadas WHERE id = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ii", $id_tarjeta, $id_usuario);
$stmt->execute();
$tarjeta = $stmt->get_result()->fetch_assoc();

if (!$tarjeta) {
    die("No puedes eliminar esta tarjeta.");
}

/* 2) Obtener recargas asociadas */
$sql_recargas = "SELECT * FROM recargas WHERE id_tarjeta = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql_recargas);
$stmt->bind_param("ii", $id_tarjeta, $id_usuario);
$stmt->execute();
$recargas = $stmt->get_result();

/* 3) Procesar cada recarga */
while ($rec = $recargas->fetch_assoc()) {

    $id_recarga = $rec['id_recarga'];

    /* OBTENER MOVIMIENTOS (si usas el ID en la descripción) */
    $sql_mov = "SELECT * FROM movimientos WHERE descripcion LIKE ?";
    $desc_mov = "%{$id_recarga}%";
    $stm_mov = $conn->prepare($sql_mov);
    $stm_mov->bind_param("s", $desc_mov);
    $stm_mov->execute();
    $movs = $stm_mov->get_result();

    while ($m = $movs->fetch_assoc()) {
        $sql_hist_mov = "
            INSERT INTO historial_tarjetas (
                id_tarjeta, id_usuario, token_tarjeta, ultimos_4, tipo_tarjeta, marca, creada_en,
                tipo_movimiento, monto, descripcion, fecha_movimiento,
                id_recarga, estado_recarga, fecha_recarga
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";

        $insm = $conn->prepare($sql_hist_mov);

        $insm->bind_param(
            "iisssssisssiiss",
            $tarjeta['id'],
            $tarjeta['id_usuario'],
            $tarjeta['token_tarjeta'],
            $tarjeta['ultimos_4'],
            $tarjeta['tipo_tarjeta'],
            $tarjeta['marca'],
            $tarjeta['creada_en'],

            $m['tipo'],
            $m['monto'],
            $m['descripcion'],
            $m['fecha'],

            $rec['id_recarga'],
            $rec['estado'],
            $rec['fecha']
        );

        $insm->execute();
    }

    /* OBTENER TRANSACCIONES WEBPAY */
    $sql_tr = "SELECT * FROM transacciones_webpay WHERE id_recarga = ?";
    $stm_tr = $conn->prepare($sql_tr);
    $stm_tr->bind_param("i", $id_recarga);
    $stm_tr->execute();
    $trs = $stm_tr->get_result();

    while ($t = $trs->fetch_assoc()) {

        $sql_hist2 = "
            INSERT INTO historial_tarjetas (
                id_tarjeta, id_usuario, token_tarjeta, ultimos_4, tipo_tarjeta, marca, creada_en,
                id_recarga, estado_recarga, fecha_recarga,
                id_transaccion, token_ws, buy_order, session_id, amount, response_code,
                authorization_code, payment_type, installments, transaction_date, status
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
        ";

        $ins2 = $conn->prepare($sql_hist2);

        $ins2->bind_param(
            "iisssssississsiississ",
            $tarjeta['id'],
            $tarjeta['id_usuario'],
            $tarjeta['token_tarjeta'],
            $tarjeta['ultimos_4'],
            $tarjeta['tipo_tarjeta'],
            $tarjeta['marca'],
            $tarjeta['creada_en'],

            $rec['id_recarga'],
            $rec['estado'],
            $rec['fecha'],

            $t['id_transaccion'],
            $t['token_ws'],
            $t['buy_order'],
            $t['session_id'],
            $t['amount'],
            $t['response_code'],

            $t['authorization_code'],
            $t['payment_type'],
            $t['installments'],
            $t['transaction_date'],
            $t['status']
        );

        $ins2->execute();
    }
}

/* 4) BORRAR todo lo relacionado */

// movimientos asociados (si aplica)
$conn->query("DELETE FROM movimientos WHERE descripcion LIKE '%$id_tarjeta%'");

// transacciones Webpay
$conn->query("DELETE FROM transacciones_webpay WHERE id_recarga IN (SELECT id_recarga FROM recargas WHERE id_tarjeta = $id_tarjeta)");

// recargas
$conn->query("DELETE FROM recargas WHERE id_tarjeta = $id_tarjeta");

// tarjeta
$conn->query("DELETE FROM tarjetas_tokenizadas WHERE id = $id_tarjeta");

/* 5) Redirigir */
header("Location: ../billetera.php?msg=tarjeta-eliminada-historial");
exit();
