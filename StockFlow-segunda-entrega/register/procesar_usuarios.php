<?php

session_start();
require_once '../dao/UsuarioDAO.php';

$nombre = $_SESSION['nombre'];
$rol    = $_SESSION['rol'];

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$nombre = trim($_POST['nombre'] ?? '');
$email = $_POST['email'] ?? '';
$password  = $_POST['password'] ?? '';
$rol  = $_POST['rol'] ?? '';


$errores = [];

if (empty($nombre)) {
    $errores[] = 'El nombre es obligatorio.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El email no tiene un formato válido.';
}

if (empty($password)) {
    $errores[] = 'El nombre es obligatorio.';
}

if (empty($rol)) {
    $errores[] = 'El nombre es obligatorio.';
}





if (!empty($errores)){
    header('Location: registrar_usuarios.php?error=1');
    exit;
}

$dao = new UsuarioDAO();
$ok = $dao->insertar($nombre, $email, $password, $rol);

if ($ok){
    header('Location: registrar_usuarios.php?ok=1');
} else {
    header('Location: registrar_usuarios?error=1');
}
exit;
?>

