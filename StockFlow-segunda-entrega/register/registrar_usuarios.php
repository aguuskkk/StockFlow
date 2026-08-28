<?php
$exito = isset($_GET['ok'])    ? 'Producto agregado correctamente.' : '';
$error = isset($_GET['error']) ? 'Hubo un error. Revisá los datos.' : '';

session_start();

$nombre = $_SESSION['nombre'];
$rol    = $_SESSION['rol'];

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
} 
if ($rol !== 'administrador') {
    header('Location: ../login/panel.php');
    exit;
}

    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista — Nuevo Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 450px; margin: 40px auto; padding: 20px; }
        input { display: block; width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #1d4ed8; color: white; border: none; cursor: pointer; font-size: 15px; }
        .ok    { color: green; margin-bottom: 12px; }
        .error { color: red;   margin-bottom: 12px; }
    </style>
</head>
<body>
    <h2>Agregar Usuario</h2>
    <a href="../login/panel.php">← Volver</a>

    <form method="POST" action="procesar_usuarios.php">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Contraseña:</label>
        <input type="text" name="password" step="0.01" min="0" required>

        <label>Rol:</label>
        <input type="text" name="rol" step="1" required>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
