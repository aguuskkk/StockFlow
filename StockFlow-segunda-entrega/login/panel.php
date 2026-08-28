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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tiendecita — Panel</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; }
        .rol { display: inline-block; background: #1d4ed8; color: white; padding: 3px 10px; border-radius: 12px; font-size: 13px; }
        nav a { margin-right: 14px; color: #1d4ed8; }
        .logout { color: red; }
        hr { margin: 20px 0; }
    </style>
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($nombre); ?></h2>
    <p>Tu rol: <span class="rol"><?php echo htmlspecialchars($rol); ?></span></p>

    <hr>

    <nav>
        <?php if ($rol === 'administrador'): ?>
            <a href="../register/panel_usuarios.php">Ver Usuarios</a>
            <a href="../register/registrar_usuarios.php">Ingresar nuevo usuario</a>

        <?php elseif ($rol === 'vendedor'): ?>
            <a href="#">Registrar Venta</a>

        <?php endif; ?>

        <a href="logout.php" class="logout">Cerrar sesión</a>
    </nav>

    <hr>
</body>
</html>
