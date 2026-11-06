<?php
session_start();

$error = $_GET['e'] ?? '404';

if (!in_array($error, ['403', '404', '500'], true)) {
    $error = '404';
}

http_response_code((int)$error);

if ($error === '403') {
    $titulo = '403';
    $mensaje = '¡Ups! No tenés permiso';
    $descripcion = 'No tenés permiso para ver esta página según tu rol';
} elseif ($error === '500') {
    $titulo = '500';
    $mensaje = '¡Ups! Algo salió mal';
    $descripcion = 'Hubo un error en el servidor. Probá de nuevo en unos minutos';
} else {
    $titulo = '404';
    $mensaje = '¡Ups! Parece que te has perdido';
    $descripcion = 'La página que buscas no existe o se ha movido a otro lugar';
}

if (isset($_SESSION['usuario_id'])) {
    $linkBoton = 'dashboard.php';
    $textoBoton = 'Volver al dashboard';
} else {
    $linkBoton = '../index.php';
    $textoBoton = 'Volver al inicio';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= $titulo ?> · StockFlow</title>
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/codes/404.css">
</head>
<body>
    <header>
        <a href="../index.php">
            <img class="header-icon" src="../assets/img/logo/logo-icon.svg" alt="Icono de StockFlow">
            <img class="header-txt" src="../assets/img/logo/logo-text.svg" alt="StockFlow">
        </a>
    </header>

    <main>
        <section class="container">
            <h1><?= $titulo ?></h1>
            <p><?= $mensaje ?></p>
            <span><?= $descripcion ?></span>
            <button class="btn-home" type="button" onclick="window.location.href='<?= $linkBoton ?>';">
                <i class="fa-solid fa-house" style="color: rgb(255, 255, 255);"></i>
                <span><?= $textoBoton ?></span>
            </button>
        </section>

        <section class="pet-container">
            <img class="pet-img" src="../assets/img/pet/perdido.png" alt="Mascota de error">
        </section>
    </main>
</body>
</html>