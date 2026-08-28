<?php
require_once '../dao/UsuarioDAO.php';
require_once '../models/usuario.php';


session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/login.php');
    exit;
}
if ($_SESSION['rol'] !== 'administrador') {
    header('Location: ../login/panel.php');
    exit;
}

$nombre = $_SESSION['nombre'];
$rol    = $_SESSION['rol'];

$dao = new UsuarioDAO();
$filas = $dao->getAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tiendecita — Panel de Usuarios</title>
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

    <table border="1" cellpadding="8">
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
        </tr>

    <?php foreach ($filas as $fila): ?>
        <?php $usuario = new Usuario($fila['id'], $fila['nombre'], $fila['email'], $fila['password'], $fila['rol']); ?>
        <tr>
            <td><?php echo $usuario->getId(); ?></td>
            <td><?php echo $usuario->getNombre(); ?></td>
            <td><?php echo $usuario->getEmail(); ?></td>
            <td><?php echo $usuario->getRol(); ?></td>
        </tr>
    <?php endforeach; ?>
    
    </table>

    <nav>

        <a href="../login/panel.php" class="panel">Volver al menu</a>
    </nav>

    <hr>
</body>
</html>
