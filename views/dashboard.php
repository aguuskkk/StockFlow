<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow · Dashboard</title>
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
                <!-- Bienvenida al usuario -->
                <div class="section-welcome">
                    <h1 id="welcome-title" class="title">¡Hola, Agustin!</h1>
                    <p id="welcome-text" class="text">Resumen de tu inventario hoy</p>
                </div>

                <!-- Tarjetas de resumen  -->
                <section class="section-cards" aria-label="Resumen de inventario">
                    <!-- Tarjeta 1: Productos totales -->
                    <article class="card" aria-label="Total de productos">
                        <i class="fa-solid fa-boxes-stacked" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Productos Totales</h3>
                            <p>1,250</p>
                        </div>
                    </article>
                    <!-- Tarjeta 2: Productos Vendidos -->
                    <article class="card" aria-label="Productos vendidos">
                        <i class="fa-solid fa-shopping-cart" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Productos vendidos</h3>
                            <p>1,250</p>
                        </div>
                    </article>
                    <!-- Tarjeta 3: Productos sin stock -->
                    <article class="card" aria-label="Productos sin stock">
                        <i class="fa-solid fa-circle-minus" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3>Productos sin stock</h3>
                            <p>185</p>
                        </div>
                    </article>
                </section>

                <!-- Charts (Solo en escritorio)-->
                <section class="section-chart" aria-label="Gráficos">
                    <!-- Ventas -->
                    <div class="chart-container">
                        <h3>Ventas de los ultimos 7 días</h3>
                        <canvas id="ventasChart" aria-label="Gráfico de ventas"></canvas>
                    </div>
                    <!-- Estado del stock -->
                    <div class="chart-container">
                        <h3>Estado del stock</h3>
                        <canvas id="stockChart" aria-label="Gráfico de stock"></canvas>
                    </div>
                </section>

                <!-- Stock Bajo -->
                <section class="section-content">
                    <!-- Título -->
                    <div class="content-title">
                        <h2>Stock bajo</h2>
                    </div>

                    <!-- Tabla de productos -->
                    <table class="content-table" aria-label="Productos con StockBajo">
                        <thead>
                            <tr>
                                <th scope="col">Producto</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Minimo</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Producto 1 -->
                            <tr>
                                <td data-label="Producto">Laptop Gamer</td>
                                <td data-label="Stock">3</td>
                                <td data-label="Minimo">10</td>
                                <td data-label="Acción">
                                    <button class="btn-reponer" aria-label="Reponer el stock">
                                        Reponer
                                    </button>
                                </td>
                            </tr>
                            <!-- Producto 2 -->
                            <tr>
                                <td data-label="Producto">Teclado Gaming</td>
                                <td data-label="Stock">2</td>
                                <td data-label="Minimo">10</td>
                                <td data-label="Acción">
                                    <button class="btn-reponer" aria-label="Reponer el stock">
                                        Reponer
                                    </button>
                                </td>
                            </tr>
                            <!-- Producto 3 -->
                            <tr>
                                <td data-label="Producto">Mouse Gaming</td>
                                <td data-label="Stock">1</td>
                                <td data-label="Minimo">10</td>
                                <td data-label="Acción">
                                    <button class="btn-reponer" aria-label="Reponer el stock">
                                        Reponer
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </main>
        </section>
    </section>

    <!-- Scripts -->
    <script src="../assets/js/profile.js"></script>
    <script src="../assets/js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Charts -->
    <script src="../assets/js/dashboard/charts.js"></script>
    <script src="../assets/js/notif.js"></script>
</body>
</html>