<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    http_response_code(403);
    echo '[]';
    exit;
}

require_once __DIR__ . '/../dao/GastosDAO.php';

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) < 2) { echo '[]'; exit; }

$dao = new GastosDAO();
$gastos = $dao->getAll();

$salida = [];
foreach ($gastos as $g) {
    if (stripos($g['descripcion'], $q) !== false || stripos($g['categoria'] ?? '', $q) !== false) {
        $salida[] = [
            'id' => (int)$g['id'],
            'descripcion' => $g['descripcion'],
            'categoria' => $g['categoria'] ?? '—',
            'monto' => (float)$g['monto'],
        ];
    }
    if (count($salida) >= 10) break;
}
echo json_encode($salida);