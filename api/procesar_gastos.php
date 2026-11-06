<?php
session_start();
require_once '../dao/GastosDAO.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    header('Location: ../views/login.php');
    exit;
}

$id          = intval($_POST['id'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$categoria   = intval($_POST['categoria'] ?? 0);
$monto       = $_POST['monto'] ?? '';
$fecha       = $_POST['fecha'] ?? '';
$estado      = $_POST['estado'] ?? '';

// Validaciones básicas
$valido = $descripcion !== ''
    && $categoria > 0
    && is_numeric($monto) && $monto >= 0
    && $fecha !== ''
    && in_array($estado, ['pagado', 'pendiente', 'cancelado'], true);

if (!$valido) {
    $volver = $id > 0 ? "gastos_form.php?id={$id}&error=1" : 'gastos_form.php?error=1';
    header("Location: ../views/{$volver}");
    exit;
}

$dao = new GastosDAO();

if ($id > 0) {
    $ok = $dao->actualizar($id, $descripcion, $categoria, $monto, $fecha, $estado);
} else {
    $ok = $dao->insertar($descripcion, $categoria, $monto, $fecha, $estado);
}

header('Location: ' . ($ok ? '../views/gastos.php?ok=1' : '../views/gastos_form.php?error=1'));
exit;
?>