<?php
session_start();
require_once '../dao/ProductoDAO.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['repositor', 'administrador'], true)) {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

$dao = new ProductoDAO();

try {
        $ok = $dao->eliminar($id, (int)$_SESSION['usuario_id']);
    echo json_encode(['ok' => (bool)$ok]);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
?>