<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes · StockFlow</title>
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

                <!-- Texto encabezado -->
                <section class="section-text">
                    <h2>Reportes</h2>
                    <p>Genera reportes personalizados de tu negocio.</p>
                </section>

                <!-- Form de filtros -->
                <section class="report-filters">
                    <form class="report-form" id="report-form">
                        <!-- Tipo -->
                        <div class="filter-group">
                            <label for="report-type" class="filter-label">Tipo de reporte</label>
                            <select id="report-type" class="filter-select" aria-label="Filtrar por tipo de reporte">
                                <option value="all">Todos los eventos</option>
                                <option value="sales">Ventas</option>
                                <option value="expenses">Gastos</option>
                                <option value="stock">Movimientos de Stock</option>
                                <option value="product">Productos</option>
                            </select>
                        </div>

                        <!-- Desde -->
                        <div class=filter-group>
                            <label for="date-from" class="filter-label">Desde</label>
                            <input type="date" id="date-from" class="filter-input" vale="2026-09-1" aria-label="Filtrar por fecha de inicio">
                        </div>

                        <!-- Hasta -->
                        <div class=filter-group>
                            <label for="date-to" class="filter-label">Hasta</label>
                            <input type="date" id="date-to" class="filter-input" vale="2026-09-30" aria-label="Filtrar por fecha de fin">
                        </div>

                        <!-- Generar reporte -->
                        <div class="filter-group filter-group-btn">
                            <button type="submit" class="btn-generate">
                                <span>Generar</span>
                            </button>
                        </div>
                    </form>

                    <!-- Resultados -->
                    <section class="report-header">
                        <div class="report-info">
                            <h3>Resultados</h3>
                            <p>
                                <span id="report-count">8 evntos</span>
                                ·
                                <span id="report-range">1/09/2026 - 30/09/2026</span>
                                ·
                                Total: <strong id="report-total">$45.000</strong>
                            </p>
                        </div>

                        <button type="button" class="btn-download" id="btn-download">
                            <i class="fa-solid fa-file-pdf" aria-hidden="true"></i>
                            <span>Descargar PDF</span>
                        </button>
                    </section>

                    <!-- Contenido Mobile -->
                    <section class="section-content mobile">
                        <div class="content-list">
                            <!-- Venta -->
                            <article class="event-item">
                                <div class="event-info">
                                    <div class="event-top">
                                        <h3 class="event-name">Venta #128</h3>
                                        <span class="type-badge sales">Venta</span>
                                    </div>
                                    <p class="event-meta">14/09/2026 · 14:32</p>
                                    <p class="event-desc">Laptop Gamer x2 · Teclado Gaming x1</p>
                                    <div class="event-bottom">
                                        <span class="event-amount positive">+$2.500</span>
                                        <span class="status-badge paid">Completada</span>
                                    </div>
                                </div>
                            </article>

                            <!-- Gasto -->
                            <article class="event-item">
                                <div class="event-info">
                                    <div class="event-top">
                                        <h3 class="event-name">Compra de insumos</h3>
                                        <span class="type-badge expenses">Gasto</span>
                                    </div>
                                    <p class="event-meta">12/09/2026 · 10:15</p>
                                    <p class="event-desc">Insumos · Proveedor: Distribuidora XYZ</p>
                                    <div class="event-bottom">
                                        <span class="event-amount negative">-$15.000</span>
                                        <span class="status-badge paid">Pagado</span>
                                    </div>
                                </div>
                            </article>

                            <!-- Movimiento Stock -->
                            <article class="event-item">
                                <div class="event-info">
                                    <div class="event-top">
                                        <h3 class="event-name">Reposición de stock</h3>
                                        <span class="type-badge stock">Stock</span>
                                    </div>
                                    <p class="event-meta">11/09/2026 · 09:00</p>
                                    <p class="event-desc">Laptop Gamer · +50 unidades</p>
                                    <div class="event-bottom">
                                        <span class="event-amount neutral">50 u.</span>
                                        <span class="status-badge paid">Confirmado</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </section>

                    <!-- Contenido Desktop -->
                    <section class="section-content desktop">
                        <table class="table-list">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Referencia</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>14/09/2026</td>
                                    <td><span class="type-badge sales">Venta</span></td>
                                    <td>Laptop Gamer x2 · Teclado Gaming x1</td>
                                    <td>#128</td>
                                    <td class="amount positive">+$2.500</td>
                                    <td><span class="status-badge paid">Completada</span></td>
                                </tr>

                                <tr>
                                    <td>12/09/2026</td>
                                    <td><span class="type-badge expenses">Gasto</span></td>
                                    <td>Compra de insumos</td>
                                    <td>Distribuidora XYZ</td>
                                    <td class="amount negative">-$15.000</td>
                                    <td><span class="status-badge paid">Pagado</span></td>
                                </tr> 

                                <tr>
                                    <td>11/09/2026</td>
                                    <td><span class="type-badge stock">Stock</span></td>
                                    <td>Reposición de stock</td>
                                    <td>Laptop Gamer</td>
                                    <td class="amount neutral">50 u.</td>
                                    <td><span class="status-badge paid">Confirmado</span></td>
                                </tr>

                                <tr>
                                    <td>10/09/2026</td>
                                    <td><span class="type-badge sales">Venta</span></td>
                                    <td>Monitor 24'' x1</td>
                                    <td>#127</td>
                                    <td class="amount positive">+$800</td>
                                    <td><span class="status-badge pending">Pendiente</span></td>
                                </tr>
       
                                <tr>
                                    <td>08/09/2026</td>
                                    <td><span class="type-badge expenses">Gasto</span></td>
                                    <td>Servicio de internet</td>
                                    <td>Fibertel</td>
                                    <td class="amount negative">-$8.500</td>
                                    <td><span class="status-badge paid">Pagado</span></td>
                                </tr>
                            </tbody>
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
</body>
</html>