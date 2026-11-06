<?php
session_start();
require_once __DIR__ . '/../dao/VentasDAO.php';
require_once __DIR__ . '/../dao/GastosDAO.php';
require_once __DIR__ . '/../dao/MovimientosDAO.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'No autorizado']);
    exit;
}

$tipo  = $_GET['tipo'] ?? 'all';
$desde = $_GET['desde'] ?? null;
$hasta = $_GET['hasta'] ?? null;

if (!in_array($tipo, ['all','sales','expenses','stock'], true)) $tipo = 'all';
if ($desde && !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$desde)) $desde = null;
if ($hasta && !preg_match('/^\d{4}-\d{2}-\d{2}$/', (string)$hasta)) $hasta = null;

$rows = [];

if (in_array($tipo, ['all','sales'], true)) {
    $dao = new VentasDAO();
    foreach ($dao->getRango($desde, $hasta) as $v) {
        $rows[] = [
            'fecha' => $v['fecha'],
            'tipo' => 'sales',
            'titulo' => 'Venta #' . $v['venta_id'],
            'descripcion' => $v['productos'],
            'monto' => (float)$v['total'],
            'estado' => $v['estado'],
        ];
    }
}

if (in_array($tipo, ['all','expenses'], true)) {
    $dao = new GastosDAO();
    foreach ($dao->getRango($desde, $hasta) as $g) {
        $rows[] = [
            'fecha' => $g['fecha'],
            'tipo' => 'expenses',
            'titulo' => $g['descripcion'],
            'descripcion' => 'Categoría: ' . ($g['categoria'] ?? '—'),
            'monto' => -(float)$g['monto'],
            'estado' => $g['estado'],
        ];
    }
}

if (in_array($tipo, ['all','stock'], true)) {
    $dao = new MovimientosDAO();
    foreach ($dao->getRango($desde, $hasta) as $m) {
        $signo = ((int)$m['cantidad'] >= 0) ? '+' : '';
        $accion = ((int)$m['cantidad'] >= 0) ? 'Entrada' : 'Salida';

        $rows[] = [
            'fecha' => $m['fecha'],
            'tipo' => 'stock',
            'titulo' => $accion . ' de ' . ($m['producto'] ?? 'Producto #' . $m['producto_id']) . ' (' . $signo . $m['cantidad'] . ' u.)',
            'descripcion' => $m['motivo'] ?? ucfirst($m['tipo']),
            'monto' => null,
            'estado' => $m['tipo'],
            'cantidad' => (int)$m['cantidad'],
        ];
    }
}

usort($rows, function($a,$b){
    return ($b['fecha'] ?? '') <=> ($a['fecha'] ?? '');
});

$totalVentas = 0; $totalGastos = 0;
foreach ($rows as $r) {
    if ($r['tipo'] === 'sales' && $r['estado'] !== 'anulada') {
        $totalVentas += (float)$r['monto'];
    }
    if ($r['tipo'] === 'expenses' && $r['estado'] !== 'cancelado') {
        $totalGastos += abs((float)$r['monto']);
    }
}

echo json_encode([
    'ok' => true,
    'rows' => $rows,
    'count' => count($rows),
    'totalVentas' => $totalVentas,
    'totalGastos' => $totalGastos,
    'totalNeto' => $totalVentas - $totalGastos,
]);