<?php
    session_start();
    require_once '../dao/VentasDAO.php';

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'vendedor' && $_SESSION['rol'] !== 'administrador') {
        header('Location: error.php?e=403');
        exit;
    }

    $ventasDAO = new VentasDAO();
    $productosMasVendidos = $ventasDAO->getProductosMasVendidosUltimos7Dias();
    $historial = $ventasDAO->getHistorialDeVentas();
    $nombre = $_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Registra y administra las ventas de tu inventario.">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/ventas/ventas.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
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
            <header aria-label="Encabezado de ventas" role="banner">
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

                <!-- Encabezado de la sección -->
                <section class="section-text">
                    <h2>Punto de venta</h2>
                    <p>Agrega productos al carrito y registra la venta</p>
                </section>

                <!-- Barra de herramientas  -->
                <div class="content-sea">
                    <div class="content-top">
                        <!-- Buscador de productos -->
                        <search class="search-input" aria-label="Buscar productos">
                            <input type="text" id="search-product" placeholder="Buscar productos...">
                            <div id="search-results" class="search-results"></div>
                            <button class="search-btn" aria-label="Buscar productos">
                                <i class="fa-solid fa-search" aria-hidden="true"></i>
                            </button>
                        </search>

                        <!-- Botón carrito (mobile y desktop) -->
                        <button type="button" class="cart-btn" id="cart-btn" title="Ver carrito" aria-label="Ver carrito">
                            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                            <span class="cart-badge" id="cart-badge">0</span>
                        </button>
                    </div>
                </div>

                <!--  Catálogo de productos  -->
                <div class="catalog">
                    <?php foreach ($productosMasVendidos as $producto): ?>

                        <article
                            class="catalog-item"
                            data-id="<?= htmlspecialchars((string) $producto['id'], ENT_QUOTES, 'UTF-8') ?>"
                            data-name="<?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>"
                            data-price="<?= htmlspecialchars((string) $producto['precio_unitario'], ENT_QUOTES, 'UTF-8') ?>"
                            data-stock="<?= htmlspecialchars((string) $producto['stock'], ENT_QUOTES, 'UTF-8') ?>"
                        >   

                            <div class="catalog-icon">
                                <i class="fa-solid fa-box" aria-hidden="true"></i>
                            </div>

                            <div class="catalog-info">

                                <h3>
                                    <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?>
                                </h3>

                                <p class="catalog-price">
                                    $<?= htmlspecialchars((string) $producto['precio_unitario'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <p class="catalog-stock">
                                    Stock:
                                    <span>
                                        <?= htmlspecialchars((string) $producto['stock'], ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </p>

                            </div>

                            <button
                                type="button"
                                class="catalog-add-btn"
                                aria-label="Agregar <?= htmlspecialchars($producto['nombre'], ENT_QUOTES, 'UTF-8') ?> al carrito"
                            >
                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            </button>

                        </article>

                    <?php endforeach; ?>
                </div>

                <!--  Historial de ventas  -->
                <section class="section-content">
                    <!-- Título -->
                    <div class="content-title">
                        <h2>Historial de ventas</h2>
                    </div>

                    <!-- Tabla (escritorio) -->
                    <table class="table-list desktop">
                        <thead>
                            <tr>
                                <th>ID</th><th>Productos</th><th>Cantidad</th>
                                <th>Total</th><th>Fecha</th><th>Estado</th><th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="sales-tbody">
                            <?php if (empty($historial)): ?>
                                <tr><td colspan="9">No hay ventas registradas todavía.</td></tr>
                            <?php else: ?>
                                <?php foreach ($historial as $v): ?>
                                    <tr data-id="<?= (int)$v['venta_id'] ?>">
                                        <td><?= (int)$v['venta_id'] ?></td>
                                        <td><?= htmlspecialchars($v['productos'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= (int)$v['cantidad'] ?></td>
                                        <td>$<?= number_format($v['total'], 2, ',', '.') ?></td>
                                        <td><?= date('d/m/Y', strtotime($v['fecha'])) ?></td>
                                        <td><?= ucfirst(htmlspecialchars($v['estado'], ENT_QUOTES, 'UTF-8')) ?></td>
                                        <td>
                                            <button class="btn-delete" data-id="<?= (int)$v['venta_id'] ?>" aria-label="Eliminar venta">
                                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Lista (mobile) -->
                    <!-- Lista (mobile) -->
                    <div class="content-list mobile" id="sales-list">
                        <?php if (empty($historial)): ?>
                            <p class="empty-sales">No hay ventas registradas todavía.</p>
                        <?php else: ?>
                            <?php foreach ($historial as $v): ?>
                                <article class="sale-item" data-id="<?= (int)$v['venta_id'] ?>">

                                    <div class="sale-info">
                                        <h3 class="sale-name">
                                            <?= htmlspecialchars($v['productos'], ENT_QUOTES, 'UTF-8') ?>
                                        </h3>
                                        <span class="status-badge <?= strtolower($v['estado']) === 'completada' ? 'completed' : 'pending' ?>">
                                            <?= ucfirst(htmlspecialchars($v['estado'], ENT_QUOTES, 'UTF-8')) ?>
                                        </span>
                                        <p class="sale-date"><?= date('d/m/Y', strtotime($v['fecha'])) ?></p>
                                        <div class="sale-meta">
                                            <p class="sale-quantity">Cantidad: <span><?= (int)$v['cantidad'] ?></span></p>
                                            <p class="sale-total">$<?= number_format($v['total'], 2, ',', '.') ?></p>
                                        </div>
                                    </div>

                                    <footer class="sale-abm">
                                        <button class="sale-btn btn-delete"
                                                data-id="<?= (int)$v['venta_id'] ?>"
                                                aria-label="Eliminar venta">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </footer>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>

            </main>

        </section>
    </section>

    <!-- --------- -->
    <!--   Carrito  -->
    <!-- --------- -->
    <aside class="cart-panel" id="cart-panel" aria-label="Carrito de compras">
        <!-- Header del carrito -->
        <div class="cart-header">
            <h2>
                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                Carrito
                <span class="cart-count" id="cart-count">0</span>
            </h2>
            <button class="cart-close" id="cart-close" aria-label="Cerrar carrito">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Lista de items -->
        <div class="cart-body" id="cart-body">
            <!-- Estado vacío -->
            <div class="cart-empty" id="cart-empty">
                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                <p>Tu carrito está vacío</p>
                <span>Agrega productos del catálogo</span>
            </div>
        </div>

        <!-- Footer con totales -->
        <div class="cart-footer" id="cart-footer">
            <div class="cart-totals">
                <div class="cart-row">
                    <span>Subtotal</span>
                    <span id="cart-subtotal">$0</span>
                </div>
                <div class="cart-row">
                    <span>IVA (22%)</span>
                    <span id="cart-tax">$0</span>
                </div>
                <div class="cart-row cart-row-total">
                    <span>Total</span>
                    <span id="cart-total">$0</span>
                </div>
            </div>
            <button type="button" class="cart-checkout" id="cart-checkout">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
                Registrar venta
            </button>
        </div>
    </aside>

    <!-- Overlay del carrito -->
    <div class="cart-overlay" id="cart-overlay"></div>

    <!--Scripts-->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/ventas/cart.js"></script>
</body>
</html>