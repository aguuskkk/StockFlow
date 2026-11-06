<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol' ]) || $_SESSION['rol'] !== 'administrador') {
        header('Location: error.php?e=403');
        exit;
    }

    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Genera reportes personalizados de tu negocio.">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/reportes/reportes.css">
</head>
<body>
    <!-- ---------- -->
    <!--   Layout   -->
    <!-- ---------- -->
    <section class="layout">
        <!-- -------- -->
        <!--   Menu   -->
        <!-- -------- -->
        <?php include_once("../include/menu.php"); ?>

        <!-- -------- -->
        <!--   Page   -->
        <!-- -------- -->
        <section class="page">
            <!-- ---------- -->
            <!--   Header   -->
            <!-- ---------- -->
            <header aria-label="Encabezado de gastos" role="banner">
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
                    <!-- Perfil de usuario -->
                    <section class="header-profile" aria-label="Perfil de usuario">
                        <button class="profile-btn" id="profileBtn" aria-label="Perfil de usuario">
                            <span class="profile-avatar"><?= $nombre[0] ?></span>
                            <span class="profile-name"><?= $nombre ?></span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <ul class="profile-list">
                                <li>
                                    <a href="perfil.php" class="dropdown-link">
                                        <i class="fa-solid fa-user" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ayuda.php" class="dropdown-link">
                                        <i class="fa-solid fa-question-circle" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Ayuda</span>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
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

                <!-- Texto encabezado -->
                <section class="section-text">
                    <h2>Reportes</h2>
                    <p>Genera reportes personalizados de tu negocio.</p>
                </section>

                <!-- Form de filtros -->
                <section class="report-filters">
                    <form class="report-form" id="report-form" method="GET" novalidate>
                        <div class="filter-group">
                            <label for="report-type" class="filter-label">Tipo de reporte</label>
                            <select id="report-type" name="tipo" class="filter-select">
                                <option value="all">Todos los eventos</option>
                                <option value="sales">Ventas</option>
                                <option value="expenses">Gastos</option>
                                <option value="stock">Stock</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="date-from" class="filter-label">Desde</label>
                            <input type="date" id="date-from" name="desde" class="filter-input" value="<?= htmlspecialchars(date('Y-m-01')) ?>">
                        </div>
                        <div class="filter-group">
                            <label for="date-to" class="filter-label">Hasta</label>
                            <input type="date" id="date-to" name="hasta" class="filter-input" value="<?= htmlspecialchars(date('Y-m-d')) ?>">
                        </div>
                        <div class="filter-group filter-group-btn">
                            <button type="submit" class="btn-generate"><span>Generar</span></button>
                        </div>
                    </form>

                    <!-- Resultados -->
                    <section class="report-header">
                        <div class="report-info">
                            <h3>Resultados</h3>
                            <p>
                                <span id="report-count">0 eventos</span>
                                <span id="report-range">—</span>
                                Total neto: <strong id="report-total">$0</strong>
                            </p>
                        </div>

                        <button type="button" class="btn-download" id="btn-download">
                            <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                            <span>Descargar PDF</span>
                        </button>
                    </section>

                    <!-- Contenido Mobile -->
                    <section class="section-content mobile">
                        <div class="content-list" id="content-list-mobile"></div>
                    </section>

                    <section class="section-content desktop">
                        <table class="table-list">
                            <thead>
                                <tr><th>Fecha</th><th>Tipo</th><th>Descripción</th><th>Monto</th><th>Estado</th></tr>
                            </thead>
                            <tbody id="table-body"></tbody>
                        </table>
                    </section>
                </section>
            </main>
        </section>    
    </section>

    <!--Scripts-->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/reportes/reportes.js"></script>
</body>
</html>