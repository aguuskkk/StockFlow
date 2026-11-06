<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dao/MovimientosDAO.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'] ?? '', ['vendedor', 'administrador'], true)) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$data  = json_decode(file_get_contents('php://input'), true);
$items = $data['items'] ?? [];

if (!is_array($items) || !$items) {
    echo json_encode(['ok' => false, 'error' => 'Carrito vacío']);
    exit;
}

$pdo = getConexion();

try {
    $pdo->beginTransaction();

    // Bloquea las filas para que dos ventas no vendan un producto al mismito tiempin
    $get = $pdo->prepare(
        "SELECT id, nombre, precio_unitario, stock
         FROM productos
         WHERE id = ? AND activo = 1
         FOR UPDATE"
    );

    $subtotal = 0;
    $lineas   = [];

    foreach ($items as $it) {
        $id   = (int)($it['id'] ?? 0);
        $cant = (int)($it['cantidad'] ?? 0);

        $get->execute([$id]);
        $p = $get->fetch(PDO::FETCH_ASSOC);

        if (!$p || $cant < 1) {
            throw new Exception('Producto inválido');
        }
        if ((int)$p['stock'] < $cant) {
            throw new Exception('Sin stock suficiente para ' . $p['nombre']);
        }

        $sub       = $p['precio_unitario'] * $cant;
        $subtotal += $sub;
        $lineas[]  = [$p['id'], $cant, $p['precio_unitario'], $sub];
    }

    $descuento = 0;
    $iva       = round($subtotal * 0.22, 2);
    $total     = $subtotal - $descuento + $iva;

    //encabezado de la venta
    $pdo->prepare(
        "INSERT INTO ventas (fecha, usuario_id, subtotal, descuento, total, iva)
         VALUES (NOW(), ?, ?, ?, ?, ?)"
    )->execute([
        (int)$_SESSION['usuario_id'],
        $subtotal, $descuento, $total, $iva
    ]);
    $ventaId = (int)$pdo->lastInsertId();

    $ins = $pdo->prepare(
        "INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario, subtotal)
         VALUES (?, ?, ?, ?, ?)"
    );
    $upd = $pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");

    foreach ($lineas as [$pid, $cant, $precio, $sub]) {
        $ins->execute([$ventaId, $pid, $cant, $precio, $sub]);
        $upd->execute([$cant, $pid]);

        // Stock nuevo DESPUÉS del UPDATE, usando la misma transacción
        $stmtStock = $pdo->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmtStock->execute([$pid]);
        $stockNuevo = (int)$stmtStock->fetchColumn();

        $movDAO = new MovimientosDAO();
        $movDAO->registrar(
            $pid,
            'salida',
            -$cant,
            $stockNuevo + $cant,
            $stockNuevo,
            (int)$_SESSION['usuario_id'],
            'Venta #' . $ventaId,
            $pdo
        );
    }

    $pdo->commit();
    echo json_encode(['ok' => true, 'venta_id' => $ventaId]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}