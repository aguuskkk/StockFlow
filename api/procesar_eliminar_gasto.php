<?php
session_start();
require_once '../dao/GastosDAO.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
    header('Location: ../views/login.php');
    exit;
}

$id = intval($_POST['id'] ?? 0);

if ($id > 0) {
    (new GastosDAO())->eliminar($id);
}

header('Location: ../views/gastos.php?ok=1');
exit;
?>