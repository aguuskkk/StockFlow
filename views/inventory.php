<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'repositor' && $_SESSION['rol'] !== 'administrador') {
        header('Location: error.php?e=403');
        exit;
    }

    require_once '../dao/ProductoDAO.php';

    $dao = new ProductoDAO();
    $productos = $dao->getAll();
    $stockBajo = $dao->getStockBajo();

    $nombre = $_SESSION['nombre'];
    $porPagina = 10;
    $pagina = max(1, intval($_GET['pagina'] ?? 1));
    $total = $dao->contarTotal();
    $paginas = ceil($total / $porPagina);
    $productos = $dao->getPaginado($pagina, $porPagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <meta name="description" content="Inventario de tus productos">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/inven/inventory.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
</head>
<body>
    
    <!-- ---..----- -->
    <!--   Layout   -->
    <!-- ---------- -->
    <section class="layout">
        <!-- -------- -->
        <!--   Menu   -->
        <!-- -------- -->
        <?php include_once("../include/menu.php"); ?>

        <!-- -------------------------- -->
        <!--   Producto Nuevo (Panel)   -->
        <!-- -------------------------- -->

        <!-- -------- -->
        <!--   Page   -->
        <!-- -------- -->
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
                <!-- Contenido (Solo mobile) -->
                <section class="section-content mobile">
                    <!-- Texto -->
                    <section class="section-text">
                        <h2>Inventario</h2>
                        <p>Lista de todos los productos que tienes en stock</p>
                    </section>

                    <div class="content-sea">
                        <!-- Barra de busqueda y agregar producto -->
                        <div class="content-top">
                            <!-- Barra de busqueda -->
                            <search class="search-input" aria-label="Buscar productos">
                                <input type="text" id="search-inventario" placeholder="Buscar productos..." autocomplete="off">
                                <div id="search-results-inv" class="search-results"></div>
                                <button type="button" class="search-btn" aria-label="Buscar productos">
                                    <i class="fa-solid fa-search" aria-hidden="true"></i>
                                </button>
                            </search>
                            <!-- Agregar producto -->
                            <button type="button" class="add-btn" id="add-btn-mobile" title="Agregar producto">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>

                        <!-- Ordenar cajas -->
                        <div class="sort-box">
                            <button type="button" class="sort-btn" id="order-btn" title="Cambiar vista" aria-label="Cambiar vista">
                                <i class="fa-solid fa-table-cells-large" style="color: var(--color-primary);"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Lista de productos -->
                    <div class="content-list" id="content-list">
                        <!-- Producto -->
                        <?php foreach ($productos as $p): ?>
                            <div class="product-item" data-id="<?= $p['id'] ?>">
                                <div class="product-info">
                                    <h3 class="product-name"><?= htmlspecialchars($p['nombre']) ?></h3>
                                    <p class="product-model">Cat: <?= htmlspecialchars($p['categoria'] ?? '—') ?></p>
                                    <p class="product-price">$<?= number_format($p['precio'], 2) ?></p>
                                    <div class="product-stock">
                                        <span class="product-stock-text">Stock: </span>
                                        <span class="product-stock-value"><?= $p['stock'] ?></span>
                                    </div>
                                    <div class="product-abm">
                                        <button class="product-btn btn-delete" aria-label="Eliminar producto">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                        <button class="product-btn btn-edit" aria-label="Editar producto">
                                            <i class="fa-solid fa-gear" aria-hidden="true"></i> 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <!-- Contenido (Solo escritorio) -->
                <section class="section-content desktop">

                    <!-- Texto -->
                    <section class="section-text">
                        <h2>Inventario</h2>
                        <p>Lista de todos los productos que tienes en stock</p>
                        <div class="content-top">
                            <search class="search-input" aria-label="Buscar productos">
                                <input type="text" id="search-inventario-desktop" placeholder="Buscar productos..." autocomplete="off">
                                <div id="search-results-inv-desktop" class="search-results"></div>
                                <button type="button" class="search-btn" aria-label="Buscar productos">
                                    <i class="fa-solid fa-search" aria-hidden="true"></i>
                                </button>
                            </search>
                            <button type="button" class="add-btn" id="add-btn-desktop" title="Agregar producto">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>  
                    </section>  

                    <!-- Lista de productos -->
                    <table class="table-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Precio unitario</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Proveedor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $p): ?>
                                <tr data-id="<?= $p['id'] ?>">
                                    <td><?= $p['id'] ?></td>
                                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= $p['stock'] ?></td>
                                    <td><?= number_format($p['precio'], 2) ?></td>
                                    <td><?= number_format($p['precio_unitario'], 2) ?></td>
                                    <td><?= htmlspecialchars($p['categoria']  ?? '—') ?></td>
                                    <td><?= $p['stock'] <= $p['stock_minimo'] ? 'Stock bajo' : 'En Stock' ?></td>
                                    <td><?= htmlspecialchars($p['proveedor'] ?? '—') ?></td>
                                    <td>
                                        <button class="btn-edit" aria-label="Editar producto">
                                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn-delete" aria-label="Eliminar producto">
                                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </section>

                <!-- Paginador -->
                <?php if ($paginas > 1): ?>
                    <div class="paginacion">
                        <?php if ($pagina > 1): ?>
                            <a href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $paginas; $i++): ?>
                            <a href="?pagina=<?= $i ?>" class="<?= $i === $pagina ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($pagina < $paginas): ?>
                            <a href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </main>
        </section>
    </section>

    <!--Scripts-->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/inven/script.js"></script>
</body>
</html>