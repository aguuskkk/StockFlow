<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    http_response_code(403);
    echo '[]';
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getConexion();

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) < 2) { echo '[]'; exit; }

$stmt = $pdo->prepare("SELECT id, nombre, email, rol FROM usuarios WHERE nombre LIKE :q OR email LIKE :q LIMIT 10");
$stmt->execute([':q' => '%' . $q . '%']);

$salida = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $u) {
    $salida[] = [
        'id' => (int)$u['id'],
        'nombre' => $u['nombre'],
        'email' => $u['email'],
        'rol' => $u['rol'],
    ];
}
echo json_encode($salida);