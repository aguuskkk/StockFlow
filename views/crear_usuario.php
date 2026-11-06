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
        header('Location: dashboard.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario · StockFlow</title>
    <meta name="description" content="Crear un nuevo usuario.">
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/usuarios/crear-usuarios.css">
</head>
<body>
    <main>
        <!------------>
        <!-- Header -->
        <!------------>
        <header class="header-crear-usuario">
            <a href="usuarios.php" aria-label="Volver al inicio de StockFlow">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>StockFlow</span>
            </a>
        </header>

        <!---------->
        <!-- Form -->
        <!---------->
        <form class="form-crear-usuario" method="POST" action="procesar_usuarios.php">
            <h1>Crear Usuario</h1>

            <section class="form-group">
                <!-- Nombre del usuario -->
                <div class="form-nombre-usuario">
                    <label for="nombre-usuario">Nombre de usuario</label>
                    <input type="text" id="nombre-usuario" name="nombre" placeholder="Ejemplo: juan" required>
                </div>

                <!-- Email del usuario -->
                <div class="form-email-usuario">
                    <label for="email-usuario">Correo electrónico</label>
                    <input type="email" id="email-usuario" name="email" placeholder="ejemplo@stockflow.com" required>
                </div>

                <!-- Contraseña del usuario -->
                <div class="form-contraseña-usuario">
                    <label for="contraseña-usuario">Contraseña</label>
                    <input type="password" id="contraseña-usuario" name="password" placeholder="Contraseña" required>
                </div>

                <!-- Rol del usuario -->
                <div class="form-rol-usuario">
                    <label for="rol-usuario">Rol</label>
                    <select id="rol-usuario" name="rol" required>
                        <option value="administrador">administrador</option>
                        <option value="vendedor">vendedor</option>
                        <option value="repositor">repositor</option>
                    </select>
                </div>

                <!-- Botón de enviar -->
                <button type="submit" class="btn-crear-usuario">
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                    <span>Crear Usuario</span>
                </button>
            </section>
        </form>
    </main>
</body>
</html>