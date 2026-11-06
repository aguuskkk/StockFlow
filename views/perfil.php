<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}


$nombre = $_SESSION['nombre'];
$rol    = $_SESSION['rol'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Gestiona tus datos personales de StockFlow.">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/perfil/perfil.css">
</head>
<body>
    <!-- ---------- -->
    <!--   Header   --> 
    <!-- ---------- -->
    <header class="profile-header">
        <a href="dashboard.php" aria-label="Volver al inicio de StockFlow">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>StockFlow</span>
        </a>
    </header>

    <!-- -------- -->
    <!--   Main   -->
    <!-- -------- -->
    <main>
        <section class="profile-content">
            <!-- Imagen decorativa -->
            <div class="profile-logo">
                <!-- Primera letra del nombre -->
                <span><?= $nombre[0] ?></span>
            </div>
            <!-- Contenido -->
            <div class="profile-info">
                <h1>Perfil</h1>
                <p>Nombre: <strong><?= $nombre ?></strong></p>
                <p>Role: <strong><?= $rol ?></strong></p>
                <a href="logout.php" class="perfil-logout" title="Cerrar sesión">
                    <i class="fa-solid fa-right-from-bracket" style="color: rgb(0, 0, 0);"></i>
                </a>
            </div>
        </section>
    </main>
</body>
</html>