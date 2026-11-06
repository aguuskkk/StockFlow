<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'] ?? '', ['repositor','administrador'], true)) {
    http_response_code(403);
    echo '[]';
    exit;
}

require_once __DIR__ . '/../dao/ProductoDAO.php';

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) < 2) { echo '[]'; exit; }

$dao = new ProductoDAO();
$productos = $dao->buscar($q);

$salida = [];
foreach (array_slice($productos, 0, 10) as $p) {
    $salida[] = [
        'id' => (int)$p['id'],
        'nombre' => $p['nombre'],
        'categoria' => $p['categoria'] ?? '—',
        'stock' => (int)$p['stock'],
    ];
}
echo json_encode($salida);