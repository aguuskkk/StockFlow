<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'] ?? '', ['repositor', 'administrador'], true)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/MovimientosDAO.php';

$id = (int)($_POST['id'] ?? 0);
$cantidad = (int)($_POST['cantidad'] ?? 0);

if ($id <= 0) {
    echo json_encode(['ok' => false, 'error' => 'ID inválido']);
    exit;
}

if ($cantidad <= 0) {
    echo json_encode(['ok' => false, 'error' => 'La cantidad debe ser mayor que 0']);
    exit;
}

$pdo = getConexion();

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id, nombre, stock FROM productos WHERE id = ? AND activo = 1 FOR UPDATE");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        $pdo->rollBack();
        echo json_encode(['ok' => false, 'error' => 'Producto no encontrado']);
        exit;
    }

    $stockAnterior = (int)$producto['stock'];
    $stockNuevo = $stockAnterior + $cantidad;

    $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
    $stmt->execute([$stockNuevo, $id]);

    $movDAO = new MovimientosDAO();
    $movDAO->registrar(
        $id,
        'entrada',
        $cantidad,
        $stockAnterior,
        $stockNuevo,
        (int)$_SESSION['usuario_id'],
        'Reposición desde dashboard',
        $pdo
    );

    $pdo->commit();
    echo json_encode(['ok' => true, 'stock_nuevo' => $stockNuevo]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}