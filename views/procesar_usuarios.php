<?php
    session_start();
    require_once '../dao/UsuarioDAO.php';

    $nombre = $_SESSION['nombre'];
    $rol    = $_SESSION['rol'];


    if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol'] ?? '') !== 'administrador') {
        http_response_code(403);
        exit;
    }

    $nombre = trim($_POST['nombre'] ?? '');
    $email = $_POST['email'] ?? '';
    $rol  = $_POST['rol'] ?? '';
    $password  = $_POST['password'] ?? '';

    $errores = [];

    if (empty($nombre)) {
        $errores[] = 'El nombre es obligatorio.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El email no tiene un formato válido.';
    }

    if (empty($password)) {
        $errores[] = 'La contraseña es obligatoria.';
    }

    if (!empty($errores)){
        header('Location: crear_usuario.php?error=1');
        exit;
    }

    $dao = new UsuarioDAO();
    $ok = $dao->insertar($nombre, $email, $password, $rol);

    if ($ok){
        header('Location: crear_usuario.php?ok=1');
    } else {
        header('Location: crear_usuario.php?error=1');
    }
    exit;
?>
