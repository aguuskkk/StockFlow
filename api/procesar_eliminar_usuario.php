<?php
session_start();
require_once '../dao/UsuarioDAO.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

if ($id === (int)$_SESSION['usuario_id']) {
    echo json_encode(['ok' => false, 'error' => 'No podés eliminar tu propia cuenta']);
    exit;
}

$dao = new UsuarioDAO();

try {
    $ok = $dao->eliminar($id);
    echo json_encode(['ok' => (bool)$ok]);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
?>