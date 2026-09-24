<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos · StockFlow</title>
    <meta name="description" content="Registra y administra los gastos de tu inventario.">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ----- Estilos ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/gastos/gastos.css">
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
                <!-- Contenedor de texto principal -->
                <section class="section-text">
                    <h2>Gastos</h2>
                    <p>Lista de todos los gastos registrados</p>
                </section>

                <!-- Tarjetas de resumen  -->
                <section class="section-cards">
                    <!-- Gastos del mes -->
                    <article class="card" aria-label="Gastos del mes">
                        <i class="fa-solid fa-calendar-day" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Gastos del mes">Gastos del mes</h3>
                            <p>$45.000</p>
                        </div>
                    </article>
                    
                    <!-- Pendientes -->
                    <article class="card" aria-label="Pagos pendientes">
                        <i class="fa-solid fa-clock" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Pagos pendientes">Pagos pendientes</h3>
                            <p>$12.000</p>
                        </div>
                    </article>

                    <!-- Gasto promedio -->
                    <article class="card" aria-label="Gasto promedio">
                        <i class="fa-solid fa-chart-simple" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Gasto promedio">Gasto promedio</h3>
                            <p>$3.750</p>
                        </div>
                    </article>

                    <!-- Categoria top -->
                     <article class="card" aria-label="Categoria más vendida">
                        <i class="fa-solid fa-tag" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Categoria más vendida">Categoría</h3>
                            <p>Informatica</p>
                        </div>
                    </article>
                </section>

                <!-- Buscador, filtros y agregar gastos -->
                <section class="section-sea">

                    <div class="content-top">
                        <!-- Buscador de gastos -->
                        <search class="search-input" aria-label="Buscar gastos">
                            <input type="text" id="search-expense" placeholder="Buscar gastos...">
                            <button class="search-btn" aria-label="Buscar gastos">
                                <i class="fa-solid fa-search" aria-hidden="true"></i>
                            </button>
                        </search>

                        <!-- Toggle de filtros --> <!-- ESTO ES SOLO MOBILE -->
                        <button type="button" class="filter-toggle" id="filter-toggle" aria-label="Mostrar filtros" aria-expanded="false" aria-controls="filters">
                            <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                        </button>

                        <!-- Botón nuevo -->
                        <a href="#" class="new-expense-btn" aria-label="Nuevo gasto">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                    <!-- Panel de filtros -->
                    <div class="filters" id="filters">

                        <!-- Categoría -->
                        <div class="filter-group">
                            <label for="filter-category" class="filter-label">Categoría</label>
                            <select id="filter-category" class="filter-select" aria-label="Filtrar por categoría">
                                <option value="">Categoría</option>
                                <option value="1">Ejemplo</option>
                                <option value="2">Ejemplo 2</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div class="filter-group">
                            <label for="filter-status" class="filter-label">Estado</label>
                            <select id="filter-status" class="filter-select" aria-label="Filtrar por estado">
                                <option value="">Estado</option>
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="filter-group">
                            <label for="filter-date" class="filter-label">Fecha</label>
                            <select id="filter-date" class="filter-select" aria-label="Filtrar por fecha">
                                <option value="">Fecha</option>
                                <option value="today">Hoy</option>
                                <option value="week">Esta semana</option>
                                <option value="month">Este mes</option>
                                <option value="year">Este año</option>
                            </select>
                        </div>

                        <!-- Limpiar filtros -->
                        <button type="button" class="filter-clear" id="filter-clear">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            limpiar
                        </button>
                    </div>
                </section>

                <!-- Lista de gastos -->
                <section class="section-content mobile">
                    <div class="content-list" id="expenses-list">
                        <!-- Gasto -->
                        <article class="expense-item">
                            <div class="expense-top">
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <div class="expense-info">
                                    <h3 class="expense-name">Compra de insumos</h3>
                                    <p class="expense-meta">Insumos · 14/09/2026</p>
                                    <div class="expense-bottom">
                                        <span class="expense-amount">$15.000</span>
                                        <span class="status-badge paid">Pagado</span>
                                    </div>
                                </div>
                            </div>
                            <div class="expense-actions">
                                <button class="btn-action btn-edit" aria-label="Editar gasto">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="btn-action btn-delete" aria-label="Eliminar gasto">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </article>

                        <article class="expense-item">
                            <div class="expense-top">
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <div class="expense-info">
                                    <h3 class="expense-name">Compra de insumos</h3>
                                    <p class="expense-meta">Insumos · 14/09/2026</p>
                                    <div class="expense-bottom">
                                        <span class="expense-amount">$15.000</span>
                                        <span class="status-badge pending">Pendiente</span>
                                    </div>
                                </div>
                            </div>
                            <div class="expense-actions">
                                <button class="btn-action btn-edit" aria-label="Editar gasto">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="btn-action btn-delete" aria-label="Eliminar gasto">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </article>

                        <article class="expense-item">
                            <div class="expense-top">
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <div class="expense-info">
                                    <h3 class="expense-name">Compra de insumos</h3>
                                    <p class="expense-meta">Insumos · 14/09/2026</p>
                                    <div class="expense-bottom">
                                        <span class="expense-amount">$15.000</span>
                                        <span class="status-badge cancelled">Cancelado</span>
                                    </div>
                                </div>
                            </div>
                            <div class="expense-actions">
                                <button class="btn-action btn-edit" aria-label="Editar gasto">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="btn-action btn-delete" aria-label="Eliminar gasto">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </article>

                        <article class="expense-item">
                            <div class="expense-top">
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <div class="expense-info">
                                    <h3 class="expense-name">Compra de insumos</h3>
                                    <p class="expense-meta">Insumos · 14/09/2026</p>
                                    <div class="expense-bottom">
                                        <span class="expense-amount">$15.000</span>
                                        <span class="status-badge paid">Pagado</span>
                                    </div>
                                </div>
                            </div>
                            <div class="expense-actions">
                                <button class="btn-action btn-edit" aria-label="Editar gasto">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    <span>Editar</span>
                                </button>
                                <button class="btn-action btn-delete" aria-label="Eliminar gasto">
                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    <span>Eliminar</span>
                                </button>
                            </div>
                        </article>
                    </div>
                </section>

                <!-- Lista de gastos desktop -->
                <section class="section-content desktop">
                    <table class="table-list">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripción</th>
                                <th>Categoría</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="expenses-tbody">

                            <tr>
                                <td>1</td>
                                <td>Compra de insumos</td>
                                <td>Insumos</td>
                                <td>$15.000</td>
                                <td>14/09/2026</td>
                                <td><span class="status-badge paid">Pagado</span></td>
                                <td>
                                    <button class="btn-edit" aria-label="Editar gasto">
                                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-delete" aria-label="Eliminar gasto">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>Servicio de internet</td>
                                <td>Servicios</td>
                                <td>$8.500</td>
                                <td>12/09/2026</td>
                                <td><span class="status-badge pending">Pendiente</span></td>
                                <td>
                                    <button class="btn-edit" aria-label="Editar gasto">
                                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-delete" aria-label="Eliminar gasto">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>IVA mensual</td>
                                <td>Impuestos</td>
                                <td>$22.000</td>
                                <td>10/09/2026</td>
                                <td><span class="status-badge paid">Pagado</span></td>
                                <td>
                                    <button class="btn-edit" aria-label="Editar gasto">
                                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn-delete" aria-label="Eliminar gasto">
                                        <i class="fa-solid fa-trash" aria-hidden="true"></i>
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
    <script src="../assets/js/notif.js"></script>
</body>
</html>