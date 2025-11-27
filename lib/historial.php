<?php

require_once __DIR__ . '/conexion.php';

function obtenerHistorial() {
    if (!isset($_SESSION['id_usuario'])) {
        return [];
    }

    global $conn;
    $id_usuario = $_SESSION['id_usuario'];

    $sql = "SELECT id_movimiento, tipo, monto, descripcion, fecha
            FROM movimientos
            WHERE id_usuario = ?
            ORDER BY fecha DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();

    $result = $stmt->get_result();
    $historial = [];

    while ($fila = $result->fetch_assoc()) {
        $historial[] = $fila;
    }

    return $historial;
}
