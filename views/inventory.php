<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario · StockFlow</title>
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
        <section class="panel-new" id="panel-new">
            <!-- Cabecera del panel -->
            <div class="panel-header">
                <button class="quit-btn" id="btn-quit" aria-label="Cerrar ventana">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
                <h2>Nuevo producto</h2>
            </div>

            <!-- Contenido del panel -->
            <div class="panel-content">
                <form class="panel-form" action="#" method="post">
                    <!-- Nombre del producto -->
                    <div class="panel-name" aria-label="Nombre del producto">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Nombre del producto...">
                    </div>
                    <!-- Descripción del producto -->
                    <div class="panel-description" aria-label="Descripción del producto">
                        <label for="description">Descripción (Opcional)</label>
                        <textarea id="description" name="description" placeholder="Descripción del producto..."></textarea>
                    </div>
                    <!-- Precio del producto y stock -->
                    <div class="panel-price-stock" aria-label="Precio y stock del producto">
                        <!-- Precio del producto -->
                        <div class="panel-price">
                            <label for="panel-price">Precio</label>
                            <input type="number" id="panel-price" name="panel-price" placeholder="Precio del producto..." title="Precio del producto">
                        </div>
                        <!-- Stock del producto -->
                        <div class="panel-stock">
                            <label for="panel-stock">Stock</label>
                            <div>
                                <button type="button" class="minus-btn" id="minus-btn" aria-label="Disminuir stock del producto">
                                    <i class="fa-solid fa-minus" aria-hidden="true"></i>
                                </button>
                                <input type="number" id="panel-stock" name="panel-stock" placeholder="Stock del producto..." title="Stock inicial del producto">
                                <button type="button" class="plus-btn" id="plus-btn" aria-label="Aumentar stock del producto">
                                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Etiquetas del producto -->
                    <div class="panel-tags">
                        <label for="panel-tags">Etiquetas (Opcional)</label>
                        <input type="text" id="panel-tags" name="panel-tags" placeholder="Etiquetas del producto...">
                    </div>
                    <!-- Botón de agregar producto -->
                    <button type="button" class="product-add-btn" id="product-btn-add" aria-label="Agregar producto">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        Agregar
                    </button>
                </form>
            </div>
        </section>

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

                    <!-- Panel de notificaciones (Aarece al hacer click) -->
                    <section class="notifications-panel" id="notifPanel">
                        <!-- Header de notificaciones -->
                        <div class="notif-header">
                            <span class="notif-title">Notificaciones</span>
                            <button class="notif-mark-all" aria-label="Marcar todas las notificaciones como leídas">
                                Marcar todas como leídas
                            </button>
                        </div>
                        <!-- Notificaciones -->
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
                        <!-- Botón de perfil -->
                        <button class="profile-btn" id="profileBtn" aria-label="Perfil de usuario">
                            <span class="profile-avatar">A</span>
                            <span class="profile-name">Agustin</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>

                        <!-- Panel de perfil -->
                        <div class="profile-dropdown" id="profileDropdown">
                            <ul class="profile-list">
                                <!-- Mi Perfil -->
                                <li>
                                    <a href="#" class="dropdown-link">
                                        <i class="fa-solid fa-user" style="color: #6b7280;" aria-hidden="true"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </li>
                                <!-- Ayuda -->
                                <li>
                                    <a href="#" class="dropdown-link">
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
                <!-- Texto (Solo en escritorio) -->
                <section class="section-text">
                    <h2>Inventario</h2>
                    <p>Lista de todos los productos que tienes en stock</p>
                </section>

                <!-- Contenido (Solo mobile) -->
                <section class="section-content mobile">
                    <div class="content-sea">
                        <!-- Barra de busqueda y agregar producto -->
                        <div class="content-top">
                            <!-- Barra de busqueda -->
                            <search class="search-input" aria-label="Buscar productos">
                                <input type="text" placeholder="Buscar productos...">
                                <button class="search-btn" aria-label="Buscar productos">
                                    <i class="fa-solid fa-search" aria-hidden="true"></i>
                                </button>
                            </search>
                            <!-- Agregar producto -->
                            <button type="button" class="add-btn" id="add-btn" title="Agregar producto">
                                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                            </button>
                        </div>

                        <!-- Ordenar cajas y fltrar -->
                        <div class="sort-box">
                            <!-- Ordenar cajas (Grid, flex, etc) -->
                            <button type="button" class="sort-btn" id="order-btn">
                                <i class="fa-solid fa-table-cells-large" style="color: var(--color-primary);"></i>
                            </button>
                            <!-- Filtrar (stock, precio, etc) -->
                            <button type="button" class="sort-btn" id="sort-btn">
                                <i class="fa-solid fa-filter" style="color: var(--color-primary);"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Lista de productos -->
                    <div class="content-list" id="content-list">
                        <!-- Producto -->
                        <div class="product-item">
                            <!-- Imagen -->
                            <div class="product-img">
                                <img src="#">
                            </div>
                            <!-- Información del producto -->
                            <div class="product-info">
                                <h3 class="product-name">Laptop Gamer</h3>
                                <p  class="product-model">Modelo: Gaming</p>
                                <p class="product-price">$1000</p>
                                <div class="product-stock">
                                    <span class="product-stock-text">Stock: </span>
                                    <span class="product-stock-value">100</span>
                                </div>
                                <!-- Eliminar y mod PRODUCTOS -->
                                <div class="product-abm">
                                    <!-- Eliminar -->
                                    <button class="product-btn" id="btn-del">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                    <!-- Modificar -->
                                    <button class="product-btn" id="btn-mod">
                                        <i class="fa-solid fa-gear" aria-hidden="true"></i> 
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Producto -->
                        <div class="product-item">
                            <!-- Imagen -->
                            <div class="product-img">
                                <img src="#">
                            </div>
                            <!-- Información del producto -->
                            <div class="product-info">
                                <h3 class="product-name">Laptop Gaming</h3>
                                <p  class="product-model">Modelo: Gaming</p>
                                <p class="product-price">$1000</p>
                                <div class="product-stock">
                                    <span class="product-stock-text">Stock: </span>
                                    <span class="product-stock-value">100</span>
                                </div>
                                <!-- Eliminar y mod PRODUCTOS -->
                                <div class="product-abm">
                                    <!-- Eliminar -->
                                    <button class="product-btn" id="btn-del">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                    <!-- Modificar -->
                                    <button class="product-btn" id="btn-mod">
                                        <i class="fa-solid fa-gear" aria-hidden="true"></i> 
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contenido (Solo escritorio) -->
            </main>
        </section>
    </section>

    <!--Scripts-->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="../assets/js/notif.js"></script>
    <script src="../assets/js/inven/order.js"></script>
    <script src="../assets/js/inven/newpro.js"></script>
</body>
</html>