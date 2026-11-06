<?php

    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    $nombre = $_SESSION['nombre'];
    $rol    = $_SESSION['rol'];

    require_once '../dao/ProductoDAO.php';
    require_once '../dao/VentasDAO.php';
    require_once '../dao/GastosDAO.php';

    //Gastos
    $dao = new GastosDAO();
    $totalGastos = $dao->getTotalMes();

    //Productos
    $dao = new ProductoDAO();
    $productos = $dao->getAll();
    $StockBajo = $dao->getStockBajo();
    $SinStock = $dao->getSinStock();

    //Ventas
    $daoVentas = new VentasDAO();
    $ventas = $daoVentas->getAll();
    $ventasUltimos7Dias = $daoVentas->getUltimos7Dias();
    $ventasUltimos30Dias = $daoVentas->getUltimos30Dias();
    $ventasPorDia = $daoVentas->getVentasPorDia();
    $resumenStock = $dao->getResumenStock();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow · Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Resumen diario de tu inventario">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
</head>
<body>

    <section class="layout">
        <!-- -------- -->
        <!--   Menu   -->
        <!-- -------- -->
        <?php include_once("../include/menu.php"); ?>

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
                <!-- Bienvenida al usuario -->
                <div class="section-welcome">
                    <h1 id="welcome-title" class="title">¡Hola, <?= $nombre ?>!</h1>
                    <p id="welcome-text" class="text">Resumen de tu inventario hoy</p>
                </div>

                <!-- Tarjetas de resumen  -->
                <section class="section-cards" aria-label="Resumen de inventario">
                    <!-- Administrador -->
                    <?php if ($rol === 'administrador'): ?>
                        <!-- Tarjeta 1: Productos totales -->
                        <article class="card" aria-label="Total de productos">
                            <i class="fa-solid fa-boxes-stacked" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Productos Totales</h3>
                                <p><?= count($productos) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 2: Ventas totales -->
                        <article class="card" aria-label="Ventas">
                            <i class="fa-solid fa-chart-line" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Ventas totales</h3>
                                <p><?= count($ventas) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 3: Gastos totales -->
                        <article class="card" aria-label="Gastos">
                            <i class="fa-solid fa-money-bill-wave" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Gastos</h3>
                                 <p>$<?= number_format((float)$totalGastos, 2, ',', '.') ?></p>
                            </div>
                        </article>
                    <?php endif; ?>

                    <!-- Vendedor -->
                    <?php if ($rol === 'vendedor'): ?>
                        <!-- Tarjeta 1: Productos vendidos -->
                        <article class="card" aria-label="Productos vendidos">
                            <i class="fa-solid fa-shopping-cart" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Productos vendidos</h3>
                                <p><?= count($ventas) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 2: Ventas los últimos 7 días -->
                        <article class="card" aria-label="Ventas">
                            <i class="fa-solid fa-calendar-days" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Ventas los últimos 7 días</h3>
                                <p><?= count($ventasUltimos7Dias) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 3: Ventas los últimos 30 días -->
                        <article class="card" aria-label="Ventas">
                            <i class="fa-solid fa-calendar-days" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Ventas los últimos 30 días</h3>
                                <p><?= count($ventasUltimos30Dias) ?></p>
                            </div>
                        </article>

                    <?php endif; ?>

                    <!-- Repositor -->
                    <?php if ($rol === 'repositor'): ?>
                        <!-- Tarjeta 1: Productos totales -->
                        <article class="card" aria-label="Total de productos">
                            <i class="fa-solid fa-boxes-stacked" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Productos Totales</h3>
                                <p><?= count($productos) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 2: Productos stock bajo  -->
                        <article class="card" aria-label="Productos sin stock">
                            <i class="fa-solid fa-arrow-trend-down" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Stock Bajo</h3>
                                <p><?= count($StockBajo) ?></p>
                            </div>
                        </article>
                        <!-- Tarjeta 3: Productos Sin Stock -->
                        <article class="card" aria-label="Productos sin stock">
                            <i class="fa-solid fa-circle-minus" style="color: rgb(0, 0, 0);"></i>
                            <div class="card-info">
                                <h3>Productos sin stock</h3>
                                <p><?= count($SinStock) ?></p>
                            </div>
                        </article>

                    <?php endif; ?>
                </section>

                <!-- Charts -->
                <section class="section-chart" aria-label="Gráficos">
                    <!-- Ventas: solo vendedor y administrador -->
                    <?php if ($rol === 'administrador' || $rol === 'vendedor'): ?>
                    <div class="chart-container">
                        <h3>Ventas de los ultimos 7 días</h3>
                        <canvas id="ventasChart" aria-label="Gráfico de ventas"></canvas>
                    </div>
                    <?php endif; ?>

                    <!-- Estado del stock: solo repositor y administrador -->
                    <?php if ($rol === 'administrador' || $rol === 'repositor'): ?>
                    <div class="chart-container">
                        <h3>Estado del stock</h3>
                        <canvas id="stockChart" aria-label="Gráfico de stock"></canvas>
                    </div>
                    <?php endif; ?>
                </section>

                <?php if ($rol === 'administrador' || $rol === 'repositor'): ?>
                <!-- Stock Bajo -->
                <section class="section-content">
                    <!-- Título -->
                    <div class="content-title">
                        <h2>Stock bajo</h2>
                    </div>

                    <!-- Tabla de productos -->
                    <table class="content-table" aria-label="Productos con stock bajo">
                        <thead>
                            <tr>
                                <th scope="col">Producto</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Mínimo</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($StockBajo)): ?>
                                <tr class="empty-row">
                                    <td colspan="4">
                                        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                                        No hay productos con stock bajo. ¡Todo en orden!
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($StockBajo as $p): ?>
                                    <tr data-id="<?= (int)$p['id'] ?>">
                                        <td data-label="Producto"><?= htmlspecialchars($p['nombre']) ?></td>
                                        <td data-label="Stock"><?= (int)$p['stock'] ?></td>
                                        <td data-label="Minimo"><?= (int)$p['stock_minimo'] ?></td>
                                        <td data-label="Acción">
                                            <button class="btn-reponer" aria-label="Reponer el stock">
                                                Reponer
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </section>
                <?php endif; ?>
            </main>
        </section>
    </section>

    <!-- Scripts -->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script>
        var ventasLabels = <?= ($rol === 'administrador' || $rol === 'vendedor') ? json_encode($ventasPorDia['labels']) : '[]' ?>;
        var ventasData = <?= ($rol === 'administrador' || $rol === 'vendedor') ? json_encode($ventasPorDia['data']) : '[]' ?>;
        var stockData = <?= ($rol === 'administrador' || $rol === 'repositor') ? json_encode([$resumenStock['normal'], $resumenStock['bajo'], $resumenStock['sin']]) : '[0,0,0]' ?>;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Charts -->
    <script src="../assets/js/dashboard/charts.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/dashboard/reponer.js"></script>
</body>
</html>