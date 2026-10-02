<?php
session_start();


require_once '../dao/ProductoDAO.php';
require_once '../dao/UsuarioDAO.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/login.php');
    exit;
}

$nombre = $_SESSION['nombre'];
$rol    = $_SESSION['rol'];

if ($rol !== 'administrador' && $rol !== 'repositor') {
    header('Location: ../login/panel.php');
    exit;
}

$nombre         = trim($_POST['nombre'] ?? '');
$precio         = trim($_POST['precio'] ?? '');
$stock          = trim($_POST['stock'] ?? '');
$descripcion    = trim($_POST['descripcion'] ?? '');

$precio = str_replace(',', '.', $precio);

$errores = [];

if (empty($nombre)) {
    $errores[] = 'El nombre del producto es obligatorio.';
}

$precio_valido = filter_var($precio, FILTER_VALIDATE_FLOAT);

if ($precio_valido === false || $precio < 0){
    $errores[] = 'El precio no puede ser negativo';
}

$stock_valido = filter_var($stock, FILTER_VALIDATE_INT);

if ($stock_valido === false || $stock < 0) {
    $errores[] = 'El stock debe ser un número entero y tampoco puede ser negativo.';
}

if (!empty($errores)){
    header('Location: ../views/inventory.php?error=1');
    exit;
}

$dao = new ProductoDAO();
$ok = $dao->insertar($nombre, $precio_valido, $stock_valido, $descripcion);

if ($ok){
    header('Location: ../views/inventory.php?ok=1');
} else {
    header('Location: ../views/inventory.php?error=1');
}
exit;
?>

