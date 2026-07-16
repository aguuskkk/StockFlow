<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos - StockFlow</title>
    <!-- ---- Iconos ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- ----- General ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- ----- Header ----- -->
    <link rel="stylesheet" href="../assets/css/bills/header-bills.css">
    <!-- ----- Main ----- -->
    <link rel="stylesheet" href="../assets/css/bills/mian-bills.css">
    <!--- FOOTER -->
    <link rel="stylesheet" href="../assets/css/footer-nav.css">
</head>
<body>
    <!------------------------->
    <!-- Header --------------->
    <!------------------------>
    <header class="bills-header">
        <!-- Botón hamburguesa-->
        <button class="bills-header_menu">
            <i class="fa-solid fa-bars" style="color: rgb(255, 255, 255);"></i>
        </button>
        <!-- Logo -->
        <div class="bills-header_logo">Gastos</div>
        <!-- Botón notificaciones -->
        <button class="bills-header_plus">
            <i class="fa-solid fa-plus" style="color: rgb(255, 255, 255);"></i>
        </button>
    </header>

    <!------------------------->
    <!-- Main --------------->
    <!------------------------>
    <main class="container">
        <section class="bills-mian">
            <!------------------------------>
            <!-- 1. Buscador --------------->
            <!------------------------------>
            <div class="bills_search">
                <input type="text" id="searchInput" placeholder="Buscar productos..." />
            </div>

            <!----------------------------->
            <!-- 2. Filtros --------------->
            <!----------------------------->
            <div class="bills_filter">
                <!-- Orden -->
                <button class="sortBtn"><i class="fa-solid fa-border-all" style="color: rgb(255, 255, 255);"></i></button>
                <!-- Filtrar por... -->
                <button class="filterBtn"><i class="fa-solid fa-filter" style="color: rgb(0, 0, 0);"></i></button>
            </div>
            
            <div class="bills-cards">
                <!-- 1. Card-->
                <div class="card">
                    <div class="card-info">
                        <h3>Alquiler de deposito</h3>
                        <div class="type<"><span>Tipos: </span>Alquiler</div>
                        <div class="price"><span>Precio: </span>$650.00</div>
                        <div class="data"><span>15/5/2026</span></div>
                    </div>
                </div>
                <!-- 2. Card -->
                <div class="card">
                    <div class="card-info">
                        <h3>Insumos</h3>
                        <div class="type<"><span>Tipos: </span>Insumos</div>
                        <div class="price"><span>Precio: </span>$1400.00</div>
                        <div class="data"><span>15/5/2026</span></div>
                    </div>
                </div>
                <!-- 3. Card -->
                <div class="card">
                    <div class="card-info">
                        <h3>Sueldos de empleados</h3>
                        <div class="type<"><span>Tipos: </span>Sueldo</div>
                        <div class="price"><span>Precio: </span>$5400.00</div>
                        <div class="data"><span>15/5/2026</span></div>
                    </div>
                </div>
                <!-- 4. Card -->
                <div class="card">
                    <div class="card-info">
                        <h3>Mecaderia</h3>
                        <div class="type<"><span>Tipos: </span>Productos</div>
                        <div class="price"><span>Precio: </span>$3000.00</div>
                        <div class="data"><span>15/5/2026</span></div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!------------------------->
    <!-- Footer --------------->
    <!------------------------>
    <?php include '../includes/footer-nav.php'; ?>
</body>
</html>