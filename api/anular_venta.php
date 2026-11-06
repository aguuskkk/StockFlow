<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || 
    !in_array($_SESSION['rol'] ?? '', ['vendedor', 'administrador'])) {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

require_once __DIR__ . '/../dao/VentasDAO.php';

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;   
}

$dao = new VentasDAO();
$result = $dao->anular($id, $_SESSION['usuario_id'] ?? null);

if ($result) {
    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'error' => 'No se pudo anular la venta']);
}