<?php
session_start();

require_once '../dao/UsuarioDAO.php';

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$dao = new UsuarioDAO();
$usuario = $dao->getByEmail($email);

if ($usuario && password_verify($password, $usuario['password'])) {

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nombre']     = $usuario['nombre'];
    $_SESSION['rol']        = $usuario['rol'];

    header('Location: ../views/dashboard.php');
    exit;
}

header('Location: ../views/login.php');
exit;
?>