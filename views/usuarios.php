<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['rol'] !== 'administrador') {
        header('Location: dashboard.php');
        exit;
    }

    require_once '../dao/UsuarioDAO.php';

    $dao      = new UsuarioDAO();
    $usuarios = $dao->getAll();
    $miId     = $_SESSION['usuario_id'];

    // Contadores por rol
    $totalUsers      = count($usuarios);
    $totalRepositores = 0;
    $totalVendedores  = 0;

    foreach ($usuarios as $u) {
        if ($u['rol'] === 'repositor')  $totalRepositores++;
        if ($u['rol'] === 'vendedor')   $totalVendedores++;
    }

    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Crea y administra las cuentas de tus trabajadores.">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/usuarios/usuarios.css">
</head>
<body>
    <section class="layout">
        <!-- Menu -->
        <?php include_once("../include/menu.php"); ?>

        <!-- Page Content -->
        <section class="page">
            <!-- ---------- -->
            <!--   Header   -->
            <!-- ---------- -->
            <header aria-label="Encabezado del dashboard" role="banner">
                <!-- Botón hamburguesa -->
                <button id="menu-btn" class="header-btn-hamburger" aria-label="Botón de navegación">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>

                <!-- Logo -->
                <div class="header-logo">
                    <a href="dashboard.php" aria-label="Volver al inicio de StockFlow">
                        StockFlow
                    </a>
                </div>

                <!-- Perfil y notificaciones -->
                <div class="header-right">
   

                    <!-- Panel de notificaciones (Aarece al hacer click) -->
                    <section class="notifications-panel" id="notifPanel">

                    <!-- Perfil de usuario -->
                    <section class="header-profile" aria-label="Perfil de usuario">
                        <!-- Botón de perfil -->
                        <button class="profile-btn" id="profileBtn" aria-label="Perfil de usuario">
                            <span class="profile-avatar"><?= $nombre[0] ?></span>
                            <span class="profile-name"><?= $nombre ?></span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <!-- Panel de perfil -->
                        <div class="profile-dropdown" id="profileDropdown">
                            <ul class="profile-list">
                                <!-- Mi Perfil -->
                                <li>
                                    <a href="perfil.php" class="dropdown-link">
                                        <i class="fa-solid fa-user" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </li>
                                <!-- Ayuda -->
                                <li>
                                    <a href="ayuda.php" class="dropdown-link">
                                        <i class="fa-solid fa-question-circle" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Ayuda</span>
                                    </a>
                                </li>
                                <!-- Idioma -->
                                <li>
                                    <div class="dropdown-link language-switch" style="display: none;">
                                        <i class="fa-solid fa-globe" style="color: #6b7280;"></i>
                                        <span>Idioma</span>
                                        <div class="switch-container">
                                            <button class="switch-btn" id="languageToggle" role="switch" aria-checked="false">
                                                <span class="switch-slider"></span>
                                                <span class="switch-label">ES</span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                                <!-- Divider -->
                                <li class="dropdown-divider"></li>
                                <!-- Cerrar sesión -->
                                <li>
                                    <a href="logout.php" class="dropdown-link">
                                        <i class="fa-solid fa-right-from-bracket" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Cerrar sesión</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </header>

            <!-- -------- -->
            <!--   Main   -->
            <!-- -------- -->
            <main role="main">
                <section class="section-text">
                    <h2>Usuarios</h2>
                    <p>Crea y administra las cuentas de tus trabajadores</p>
                </section>

                <!-- Tarjetas de resumen  -->
                <section class="section-cards" aria-label="Resumen de usuarios">
                    <!-- Usuarios totales -->
                    <article class="card" aria-label="Total de usuarios">
                        <i class="fa-solid fa-user-group" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Usuarios totales</h3>
                            <p><?= $totalUsers ?></p>
                        </div>
                    </article>
                    <!-- Usuarios con rol repositor -->
                    <article class="card" aria-label="Usuarios con rol repositor">
                        <i class="fa-solid fa-user-group" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Repositores</h3>
                            <p><?= $totalRepositores ?></p>
                        </div>
                    </article>
                    <!-- Usuarios con el rol vendedor -->
                    <article class="card" aria-label="Usuarios con el rol vendedor">
                        <i class="fa-solid fa-user-group" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Vendedores</h3>
                            <p><?= $totalVendedores ?></p>
                        </div>
                    </article>
                </section>

                <!-- Barra de busqueda y botón de agregar usuario -->
                <section class="section-sea">
                    <div class="content-top">
                        <search class="search-input" aria-label="Buscar usuarios">
                            <input type="text" id="search-user" placeholder="Buscar usuarios..." autocomplete="off">
                            <div id="search-results-user" class="search-results"></div>
                            <button type="button" class="search-btn" aria-label="Buscar usuarios">
                                <i class="fa-solid fa-search" aria-hidden="true"></i>
                            </button>
                        </search>
                        <a href="crear_usuario.php" class="new-user-btn" aria-label="Nuevo usuario" title="Nuevo usuario">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            <span>Nuevo usuario</span>
                        </a>
                    </div>
                </section>

                <!-- Lista de usuarios -->
                <section class="section-content desktop">
                    <table class="table-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="users-tbody">
                            <?php if (empty($usuarios)): ?>
                                <tr>
                                    <td colspan="5" class="no-user-text">No hay usuarios registrados todavía.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($usuarios as $u): ?>
                                    <tr data-id="<?= $u['id'] ?>">
                                        <td><?= $u['id'] ?></td>
                                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td>
                                            <span class="role-badge <?= htmlspecialchars($u['rol']) ?>">
                                                <?= ucfirst($u['rol']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn-delete" aria-label="Eliminar usuario"
                                                <?= (int)$u['id'] === (int)$miId ? 'disabled title="No puedes eliminar tu propia cuenta"' : '' ?>>
                                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>

                <!-- Lista de usuarios (Mobile) -->
                <section class="section-content mobile">
                    <div class="content-list" id="users-list">
                        <?php if (empty($usuarios)): ?>
                            <p class="no-user-text">No hay usuarios registrados todavía.</p>
                        <?php else: ?>
                            <?php foreach ($usuarios as $u): ?>
                                <article class="user-item" data-id="<?= $u['id'] ?>">
                                    <div class="user-avatar"><?= strtoupper($u['nombre'][0]) ?></div>
                                    <div class="user-info">
                                        <h3 class="user-name"><?= htmlspecialchars($u['nombre']) ?></h3>
                                        <p class="user-email"><?= htmlspecialchars($u['email']) ?></p>
                                        <span class="role-badge <?= htmlspecialchars($u['rol']) ?>">
                                            <?= ucfirst($u['rol']) ?>
                                        </span>
                                    </div>
                                    <button class="btn-delete" aria-label="Eliminar usuario"
                                        <?= (int)$u['id'] === (int)$miId ? 'disabled title="No puedes eliminar tu propia cuenta"' : '' ?>>
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </section>
    </section>

    <!-- Scripts -->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/usuarios/usuarios.js"></script>
    
</body>
</html>