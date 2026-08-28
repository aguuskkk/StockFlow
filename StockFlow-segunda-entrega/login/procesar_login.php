<?php
session_start();

require_once '../dao/UsuarioDAO.php';

$errores = [];

$email      = trim($_POST['email'] ?? '');
$password   = $_POST['password'] ?? '';

if (empty($email)) {
    $errores[] = 'El email es obligatorio.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El email no tiene un formato válido.';
}

if (empty($password)) {
    $errores[] = 'La contraseña es obligatoria.';
}

if (!empty($errores)) {
    header('Location: login.php?error=1');
    exit;
}

$dao = new UsuarioDAO();
$usuario = $dao->getByEmail($email);

if ($usuario && password_verify($password, $usuario['password'])) {

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre']     = $usuario['nombre'];
    $_SESSION['rol']        = $usuario['rol'];

header('Location: panel.php'); 
exit;

} else {
    header('Location: login.php?error=1'); 
}


?>

