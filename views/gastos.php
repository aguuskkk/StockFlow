<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
        header('Location: error.php?e=403');
        exit;
    }

    $nombre = $_SESSION['nombre'];

    require_once '../dao/GastosDAO.php';

    $dao       = new GastosDAO();
    $gastos    = $dao->getAll();
    $totalMes  = $dao->getTotalMes();
    $pendiente = $dao->getTotalPendiente();
    $promedio  = $dao->getPromedioMes();
    $catTop    = $dao->getCategoriaTop();

    $clases = ['pagado' => 'paid', 'pendiente' => 'pending', 'cancelado' => 'cancelled'];
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos · StockFlow</title>
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
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
                            <p><?= '$' . number_format($totalMes, 2, ',', '.') ?></p>
                        </div>
                    </article>
                    
                    <!-- Pendientes -->
                    <article class="card" aria-label="Pagos pendientes">
                        <i class="fa-solid fa-clock" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Pagos pendientes">Pagos pendientes</h3>
                            <p><?= '$' . number_format($pendiente, 2, ',', '.') ?></p>
                        </div>
                    </article>

                    <!-- Gasto promedio -->
                    <article class="card" aria-label="Gasto promedio">
                        <i class="fa-solid fa-chart-simple" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Gasto promedio">Gasto promedio</h3>
                            <p><?= '$' . number_format($promedio, 2, ',', '.') ?></p> 
                        </div>
                    </article>

                    <!-- Categoria top -->
                     <article class="card" aria-label="Categoria más vendida">
                        <i class="fa-solid fa-tag" style="color: rgb(0, 0, 0);"></i>
                        <div class="card-info">
                            <h3 title="Categoria más vendida">Categoría</h3>
                            <p><?= htmlspecialchars($catTop ?? '—') ?></p>   
                        </div>
                    </article>
                </section>

                <!-- Buscador, filtros y agregar gastos -->
                <section class="section-sea">

                    <div class="content-top">
                        <!-- Buscador de gastos -->
                        <search class="search-input" aria-label="Buscar gastos">
                            <input type="text" id="search-expense" placeholder="Buscar gastos..." autocomplete="off">
                            <div id="search-results-gas" class="search-results"></div>
                            <button type="button" class="search-btn" aria-label="Buscar gastos">
                                <i class="fa-solid fa-search" aria-hidden="true"></i>
                            </button>
                        </search>

                    
                        <!-- Toggle de filtros --> <!-- ESTO ES SOLO MOBILE -->
                         <!--
                        <button type="button" class="filter-toggle" id="filter-toggle" aria-label="Mostrar filtros" aria-expanded="false" aria-controls="filters">
                            <i class="fa-solid fa-sliders" aria-hidden="true"></i>
                        </button>
                        -->
                        <!-- Botón nuevo -->
                        <a href="gastos_form.php" class="new-expense-btn" aria-label="Nuevo gasto">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                    <!-- Panel de filtros -->
                    <!--
                    <div class="filters" id="filters">

                        <div class="filter-group">
                            <label for="filter-category" class="filter-label">Categoría</label>
                            <select id="filter-category" class="filter-select" aria-label="Filtrar por categoría">
                                <option value="">Categoría</option>
                                <option value="1">Ejemplo</option>
                                <option value="2">Ejemplo 2</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="filter-status" class="filter-label">Estado</label>
                            <select id="filter-status" class="filter-select" aria-label="Filtrar por estado">
                                <option value="">Estado</option>
                                <option value="pagado">Pagado</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>

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

                        <button type="button" class="filter-clear" id="filter-clear">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            limpiar
                        </button>
                    </div>
                    -->
                </section>

                <!-- Lista de gastos -->
                <section class="section-content mobile">
                    <div class="content-list" id="expenses-list">
                        <?php foreach ($gastos as $g): ?>
                        <article class="expense-item">
                            <div class="expense-top">
                                <i class="fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                                <div class="expense-info">
                                    <h3 class="expense-name"><?= htmlspecialchars($g['descripcion']) ?></h3>
                                    <p class="expense-meta"><?= htmlspecialchars($g['categoria'] ?? '—') ?> · <?= date('d/m/Y', strtotime($g['fecha'])) ?></p>
                                    <div class="expense-bottom">
                                        <span class="expense-amount">$<?= number_format($g['monto'], 2, ',', '.') ?></span>
                                        <span class="status-badge <?= $clases[$g['estado']] ?>"><?= ucfirst($g['estado']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="expense-actions">
                                <a href="gastos_form.php?id=<?= $g['id'] ?>" class="btn-action btn-edit">
                                    <i class="fa-solid fa-pen-to-square"></i><span>Editar</span>
                                </a>
                                <form method="post" action="../api/procesar_eliminar_gasto.php" onsubmit="return confirm('¿Eliminar este gasto?')" style="display:inline">
                                    <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fa-solid fa-trash"></i><span>Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </article>
                        <?php endforeach; ?>
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
                            <?php foreach ($gastos as $g): ?>
                            <tr>
                                <td><?= $g['id'] ?></td>
                                <td><?= htmlspecialchars($g['descripcion']) ?></td>
                                <td><?= htmlspecialchars($g['categoria'] ?? '—') ?></td>
                                <td>$<?= number_format($g['monto'], 2, ',', '.') ?></td>
                                <td><?= date('d/m/Y', strtotime($g['fecha'])) ?></td>
                                <td><span class="status-badge <?= $clases[$g['estado']] ?>"><?= ucfirst($g['estado']) ?></span></td>
                                <td>
                                    <a href="gastos_form.php?id=<?= $g['id'] ?>" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form method="post" action="../api/procesar_eliminar_gasto.php" onsubmit="return confirm('¿Eliminar este gasto?')" style="display:inline">
                                        <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                        <button type="submit" class="btn-delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
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
    <script src="../assets/js/gastos/gastos_buscar.js"></script>
</body>
</html>