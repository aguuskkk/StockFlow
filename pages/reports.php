<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - StockFlow</title>
    <!-- ---- Iconos ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- ----- General ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- ----- Header ----- -->
    <link rel="stylesheet" href="../assets/css/reports/header-reports.css">
    <!-- ----- Main ----- -->
    <link rel="stylesheet" href="../assets/css/reports/main-reports.css">
    <!-- ----- Footer ----- -->
    <link rel="stylesheet" href="../assets/css/footer-nav.css">
</head>
<body>
    <!------------------------->
    <!-- Header --------------->
    <!------------------------>
    <header class="reports-header">
        <!-- Botón hamburguesa-->
        <button class="reports-header_menu">
            <i class="fa-solid fa-bars" style="color: rgb(255, 255, 255);"></i>
        </button>
        <!-- Logo -->
        <div class="reports-header_logo">Reportes</div>
        <!-- Botón notificaciones -->
        <button class="reports-header_notifications">
            <i class="fa-solid fa-bell" style="color: rgb(255, 255, 255);"></i>
            <span class="badge">9</span><!-- Numero de notificaciones -->
        </button>
    </header>

    <!------------------------->
    <!-- Main --------------->
    <!------------------------>
    <main class="container">
        <!-- Data-->
        <section class="reports-data">
            <!-- Data de-->
            <div class="data-cont">
                <h3>Desde</h3>
                <button class="data">
                    <i class="fa-solid fa-calendar-days" style="color: rgb(61, 61, 61);"></i>
                    <label>6/4/2026</label>
                </button>
            </div>
            <!-- Data hasta-->
            <div class="data-cont">
                <h3>Hasta</h3>
                <button class="data">
                    <i class="fa-solid fa-calendar-days" style="color: rgb(61, 61, 61);"></i>
                    <label>6/5/2026</label>
                </button>
            </div>
        </section>
        <!-- Tipo -->
        <section class="reports-type"> 
            <label for="">Tipo de reporte</label>
            <select name="types" class="report-select">
                <option value="Select">Seleccionar</option>
                <option value="Gastos">Gastos</option>
                <option value="Ventas">Ventas</option>
                <option value="Stock">Stock</option>
            </select>
        </section>
        <!-- Generar reporte -->
        <button class="report-add" type="button">Generar reporte</button>

        <div class="report-list">
            <h2>Lista de reportes</h2>
            <!-- 1. Card-->
            <div class="card">
                <!-- Infomrmación de la card-->
                <div class="info-card">
                    <h3>Gastos</h3>
                    <div class="type"><span>Tipo: </span>Gastos</div>
                    <div class="data">6/5/2026 - 6/6/2026</div>
                </div>
                <!-- Acciones de la card-->
                <div class="action-card">
                    <div class="archive-type">PDF</div>
                    <button class="down">Descargar</button>
                </div>
            </div>
            <!-- 2. Card-->
            <div class="card">
                <!-- Infomrmación de la card-->
                <div class="info-card">
                    <h3>Reponer Stock</h3>
                    <div class="type"><span>Tipo: </span>Stoc</div>
                    <div class="data">6/4/2026 - 6/5/2026</div>
                </div>
                <!-- Acciones de la card-->
                <div class="action-card">
                    <div class="archive-type">PDF</div>
                    <button class="down">Descargar</button>
                </div>
            </div>
            <!-- 1. Card-->
            <div class="card">
                <!-- Infomrmación de la card-->
                <div class="info-card">
                    <h3>Ventas del mes</h3>
                    <div class="type"><span>Tipo: </span>Ventas</div>
                    <div class="data">6/2/2026 - 6/3/2026</div>
                </div>
                <!-- Acciones de la card-->
                <div class="action-card">
                    <div class="archive-type">PDF</div>
                    <button class="down">Descargar</button>
                </div>
            </div>
        </div>
    </main>

    <!------------------------->
    <!-- Footer --------------->
    <!------------------------>

    <?php include '../includes/footer-nav.php'; ?>
</body>
</html>