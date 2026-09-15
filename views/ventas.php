<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas · StockFlow</title>
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
                    <a href="../index.html" aria-label="Volver al inicio de StockFlow">
                        StockFlow
                    </a>
                </div>

                <!-- Perfil y notificaciones -->
                <div class="header-right">
                    <!-- Botón de notificaciones -->
                    <button class="header-btn-notifications" id="notifBtn" aria-label="Notificaciones">
                        <i class="fa-solid fa-bell" aria-hidden="true"></i>
                        <span class="badge">9</span>
                    </button>

                    <!-- Panel de notificaciones -->
                    <section class="notifications-panel" id="notifPanel">
                        <div class="notif-header">
                            <span class="notif-title">Notificaciones</span>
                            <button class="notif-mark-all" aria-label="Marcar todas las notificaciones como leídas">
                                Marcar todas como leídas
                            </button>
                        </div>
                        <ul class="notif-list">
                            <li class="notif-item unread">
                                <i class="fa-solid fa-box"></i>
                                <div class="notif-content">
                                    <p class="notif-text"><strong>Laptop Gamer</strong> está por debajo del stock mínimo.</p>
                                    <span class="notif-time">Hace 5 minutos</span>
                                </div>
                            </li>
                            <li class="notif-item unread">
                                <i class="fa-solid fa-box"></i>
                                <div class="notif-content">
                                    <p class="notif-text"><strong>Teclado Gaming</strong> está por debajo del stock mínimo.</p>
                                    <span class="notif-time">Hace 12 minutos</span>
                                </div>
                            </li>
                            <li class="notif-item unread">
                                <i class="fa-solid fa-box"></i>
                                <div class="notif-content">
                                    <p class="notif-text"><strong>Mouse Gaming</strong> está por debajo del stock mínimo.</p>
                                    <span class="notif-time">Hace 20 minutos</span>
                                </div>
                            </li>
                            <li class="notif-item">
                                <i class="fa-solid fa-box"></i>
                                <div class="notif-content">
                                    <p class="notif-text">Nueva venta de <strong>Laptop Gamer</strong> ha sido registrada.</p>
                                    <span class="notif-time">Hace 30 minutos</span>
                                </div>
                            </li>
                        </ul>
                    </section>

                    <!-- Perfil de usuario -->
                    <section class="header-profile" aria-label="Perfil de usuario">
                        <button class="profile-btn" id="profileBtn" aria-label="Perfil de usuario">
                            <span class="profile-avatar">A</span>
                            <span class="profile-name">Agustin</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <div class="profile-dropdown" id="profileDropdown">
                            <ul class="profile-list">
                                <li>
                                    <a href="#" class="dropdown-link">
                                        <i class="fa-solid fa-user" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-link">
                                        <i class="fa-solid fa-question-circle" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Ayuda</span>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="#" class="dropdown-link">
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
                <section class="catalog" id="catalog" aria-label="Catálogo de productos">
                    <!-- Producto -->
                    <article class="catalog-item" data-id="1" data-name="Laptop Gamer" data-price="1000" data-stock="100">
                        <div class="catalog-icon">
                            <i class="fa-solid fa-laptop" aria-hidden="true"></i>
                        </div>
                        <div class="catalog-info">
                            <h3>Laptop Gamer</h3>
                            <p class="catalog-price">$1000</p>
                            <p class="catalog-stock">Stock: <span>100</span></p>
                        </div>
                        <button type="button" class="catalog-add-btn" aria-label="Agregar Laptop Gamer al carrito">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                    </article>

                    <!-- Producto -->
                    <article class="catalog-item" data-id="2" data-name="Teclado Gaming" data-price="500" data-stock="50">
                        <div class="catalog-icon">
                            <i class="fa-solid fa-keyboard" aria-hidden="true"></i>
                        </div>
                        <div class="catalog-info">
                            <h3>Teclado Gaming</h3>
                            <p class="catalog-price">$500</p>
                            <p class="catalog-stock">Stock: <span>50</span></p>
                        </div>
                        <button type="button" class="catalog-add-btn" aria-label="Agregar Teclado Gaming al carrito">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                    </article>

                    <!-- Producto -->
                    <article class="catalog-item" data-id="3" data-name="Mouse Gaming" data-price="300" data-stock="25">
                        <div class="catalog-icon">
                            <i class="fa-solid fa-computer-mouse" aria-hidden="true"></i>
                        </div>
                        <div class="catalog-info">
                            <h3>Mouse Gaming</h3>
                            <p class="catalog-price">$300</p>
                            <p class="catalog-stock">Stock: <span>25</span></p>
                        </div>
                        <button type="button" class="catalog-add-btn" aria-label="Agregar Mouse Gaming al carrito">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                    </article>

                    <!-- Producto -->
                    <article class="catalog-item" data-id="4" data-name="Monitor 24''" data-price="800" data-stock="15">
                        <div class="catalog-icon">
                            <i class="fa-solid fa-desktop" aria-hidden="true"></i>
                        </div>
                        <div class="catalog-info">
                            <h3>Monitor 24''</h3>
                            <p class="catalog-price">$800</p>
                            <p class="catalog-stock">Stock: <span>15</span></p>
                        </div>
                        <button type="button" class="catalog-add-btn" aria-label="Agregar Monitor 24'' al carrito">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                    </article>
                </section>

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
                                <th>ID</th>
                                <th>Productos</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="sales-tbody">
                            <tr>
                                <td>1</td>
                                <td>Laptop Gamer</td>
                                <td>2</td>
                                <td>$2000</td>
                                <td>14/09/2026</td>
                                <td>Completada</td>
                                <td>
                                    <button class="btn-edit" aria-label="Editar venta">
                                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-delete" aria-label="Eliminar venta">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Teclado Gaming</td>
                                <td>1</td>
                                <td>$500</td>
                                <td>14/09/2026</td>
                                <td>Pendiente</td>
                                <td>
                                    <button class="btn-edit" aria-label="Editar venta">
                                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-delete" aria-label="Eliminar venta">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Lista (mobile) -->
                    <div class="content-list mobile" id="sales-list">
                        <div class="sale-item">
                            <div class="sale-info">
                                <h3 class="sale-name">Laptop Gamer</h3>
                                <p class="sale-date">14/09/2026 · 14:32</p>
                                <p class="sale-quantity">Cantidad: <span>2</span></p>
                                <p class="sale-total">$2000</p>
                            </div>
                            <div class="sale-status">
                                <span class="status-badge completed">Completada</span>
                            </div>
                            <div class="sale-abm">
                                <button class="sale-btn" id="btn-del">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                </button>
                                <button class="sale-btn" id="btn-mod">
                                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
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