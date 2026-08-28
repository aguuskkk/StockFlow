<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

$error = isset($_GET['error']) ? 'Email o Contraseña incorrectos.' : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .error { color: red; margin-bottom: 12px; }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · StockFlow</title>
    <meta name="description" content="Accede a tu cuenta de StockFlow para gestionar tu inventario y ventas.">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login/login.css">
</head>
<body>
    <!-- ---------- -->
    <!--   Header   -->
    <!-- ---------- -->
    <header class="login-header">
        <a href="../index.php" aria-label="Volver al inicio de StockFlow">
            <img class="header-icon" src="../assets/img/logo/logo-icon.svg" alt="Icono de StockFlow">
            <img class="header-txt" src="../assets/img/logo/logo-text.svg" alt="StockFlow">
        </a>
    </header>

    <!-- -------- -->
    <!--   Main   -->
    <!-- -------- -->
    <main>
        <section class="login-section">
            <!-- Imagen decorativa -->
            <figure class="login-image" style="display: none;">
                <img src="#" alt="Imagen decorativa">
            </figure>

            <!-- Conteido principal del formulario  -->
            <section class="login-content">
                <!-- Texto del formulario-->
                <div class="login-header-text">
                    <h1>Iniciar sesión</h1>
                    <p>Ingresa tus datos para acceder a tu cuenta</p>
                </div>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
                <!-- Formulario -->
                <form class="login-form" id="LoginForm" action="procesar_login.php" method="POST" novalidate>
                    <!-- Correo electrónico -->
                    <section class="form-group">
                        <label for="email">Correo electrónico</label>
                        <div class="input-group">
                            <i class="fa-regular fa-envelope" aria-hidden="true"></i>
                            <input type="email" name="email" id="email" placeholder="ejemplo@ejemplo.com" required autocomplete="email" required>
                        </div>
                    </section>

                    <!-- Contraseña -->
                    <section class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                            <i class="fa-solid fa-lock" aria-hidden="true"></i>
                            <input type="password" name="password" id="password" placeholder="Ingresa tu contraseña" required autocomplete="current-password" required>
                            <button type="button" class="toggle-password" aria-label="Mostrar contraseña">
                                <i class="fa-regular fa-eye" aria-hidden="true"></i>
                            </button>
                        </div>
                    </section>

                    <!-- Botón de enviar -->
                    <button type="submit">Iniciar sesión</button>

                    <!-- Olvidaste la contraseña ¿? -->
                    <div class="divider">
                        <span></span>
                        <span>o</span>
                        <span></span>
                    </div>
                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>

                </form>
            </section>
        </section>
    </main>

    <!-- ---------- -->
    <!--   Footer   -->
    <!-- ---------- -->
    <footer>
        <div class="footer-languages">
            <button class="btn-idioma" aria-label="Cambiar a español">
                <img src="../assets/img/icon/flags/es.svg" alt="Bandera España" aria-hidden="true">
                <span>Español</span>
            </button>
            <button class="btn-idioma" aria-label="Switch to English">
                <img src="../assets/img/icon/flags/um.svg" alt="USA flag" aria-hidden="true">
                <span>English</span>
            </button>
        </div>
    </footer>

</body>
</html>