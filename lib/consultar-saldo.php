<?php

require_once __DIR__ . '/conexion.php';

function consultarSaldo() {
    // ❌ YA NO USAMOS session_start() aquí
    
    if (!isset($_SESSION['id_usuario'])) {
        return 0;
    }

    $id_usuario = $_SESSION['id_usuario'];
    global $conn;

    $sql = "SELECT 
                COALESCE(SUM(CASE WHEN tipo = 'recarga' THEN monto END), 0) -
                COALESCE(SUM(CASE WHEN tipo = 'gasto' THEN monto END), 0) 
            AS saldo
            FROM movimientos
            WHERE id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    return $row['saldo'] ?? 0;
}
?>
