<?php
require_once __DIR__ . '/../dao/ProductoDAO.php';
header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) < 2) { echo '[]'; exit; }

$dao = new ProductoDAO();
$productos = $dao->buscar($q);


$salida = [];
foreach (array_slice($productos, 0, 10) as $p) {
    if ((int)$p['stock'] <= 0) continue;
    $salida[] = [
        'id'     => (int)$p['id'],
        'nombre' => $p['nombre'],
        'precio_unitario' => (float)$p['precio_unitario'],
        'stock'  => (int)$p['stock'],
    ];
}   
echo json_encode($salida);