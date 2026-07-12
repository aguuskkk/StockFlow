<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- ---- Iconos ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- ----- Styles ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- ----- Header ----- -->
    <link rel="stylesheet" href="../assets/css/dashboard/header-dashboard.css">
    <!-- ----- Main ----- -->
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard-main/welcome.css"> <!-- (Sección de bienvenida)-->
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard-main/cards.css"> <!-- (Sección de cards)-->
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard-main/table.css"> <!-- (Sección tabla stock bajo)-->
    <link rel="stylesheet" href="../assets/css/dashboard/dashboard-main/product.css"> <!-- (Sección de prodcutos más vendidos)-->
    <!-- ----- Footer ----- -->
    <link rel="stylesheet" href="../assets/css/footer-nav.css">
</head>
<body>  
    <!------------------------->
    <!-- Header --------------->
    <!------------------------>
    <header class="dashboard-header">
        <!-- Botón hamburguesa-->
        <button class="dashboard-header_menu">
            <i class="fa-solid fa-bars" style="color: rgb(255, 255, 255);"></i>
        </button>
        <!-- Logo -->
        <div class="dashboard-header_logo">StockFlow</div>
        <!-- Botón notificaciones -->
        <button class="dashboard-header_notifications">
            <i class="fa-solid fa-bell" style="color: rgb(255, 255, 255);"></i>
            <span class="badge">9</span><!-- Numero de notificaciones -->
        </button>
    </header>

    <!------------------------->
    <!-- Main ----------------->
    <!------------------------->    
    <main class="dashboard-main">
        <!--------------------------------->
        <!-- 1. Encabezado de bienvenida -->
        <!--------------------------------->
         <section class="dashboard-main_welcome">
            <h1 class="title">¡Hola, Agustin!</h1>
            <p class="sub-title">Este es el resumen de tu inventario hoy</p>
         </section>

        <!---------------------------->
        <!-- 2. Tarjetas de resumen -->
        <!---------------------------->
        <section class="dashboard-main_cards">
            <!-- 2.1. Primera tarjeta -->
            <div class="card">
                <i class="fa-solid fa-boxes-stacked" style="color: rgb(0, 0, 0);"></i>
                <div class="card-info">
                    <h3>Productos</h3>
                    <p>1,250</p>
                </div>
            </div>
            <!-- 2.2. Segunda tarjeta -->
            <div class="card">
                <i class="fa-solid fa-arrows-rotate" style="color: rgb(0, 0, 0);"></i>
                <div class="card-info">
                    <h3>Sin Stock</h3>
                    <p>12</p>
                </div>
            </div>
            <!-- 2.3 Tercera tarjeta -->
            <div class="card">
                <i class="fa-solid fa-arrow-trend-up" style="color: rgb(0, 0, 0);"></i>
                <div class="card-info">
                    <h3>Ventas (Hoy)</h3>
                    <p>$450.00</p>
                </div>
            </div>
        </section>

        <!------------------->
        <!-- 3. Stock bajo -->
        <!------------------->
        <section class="dashboard-content">
            <!-- Titulo de la seccion-->
            <div class="dashboard-content_stock">
                <h2>Stock Bajo</h2>
            </div>
            <!-- Tabla -->
            <div class="dashboard-content_table">
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Minimo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <!-- Items-->
                    <tbody>
                        <!-- Item 1-->
                        <tr>
                            <td>Laptop Gamer</td>
                            <td>3</td>
                            <td>10</td>
                            <td><button class="btn-reponer">Reponer</button></td>
                        </tr>
                        <!-- Item 2 -->
                        <tr>
                            <td>Mouse optico</td>
                            <td>4</td>
                            <td>10</td>
                            <td><button class="btn-reponer">Reponer</button></td>
                        </tr>
                        <!-- Item 3 -->
                        <tr>
                            <td>Teclado mecanico</td>
                            <td>2</td>
                            <td>10</td>
                            <td><button class="btn-reponer">Reponer</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!------------------------------->
        <!-- 4. Productos más vendidos -->
        <!------------------------------->

        <section class="dashboard-product">
            <!-- Titulo-->
            <div class="dashboard-product_titletop">
                <h2>Productos más vendidos</h2>
            </div>
            <!-- Productos más vendidos-->
            <div class="dashboard-product_top">
                <!-- Tarjeta 1-->
                <div class="product-card product-1">
                    <img src="../assets/img/img_not_found.png">
                    <div class="product-info">
                        <h3>Laptop gamer</h3>
                        <p>$1299</p>
                    </div>
                </div>
                <!-- Tarjeta 2 -->
                <div class="product-card product-2">
                    <img src="../assets/img/img_not_found.png">
                    <div class="product-info">
                        <h3>iPhone 23</h3>
                        <p>$4999</p>
                    </div>
                </div>
                <!-- Tarjeta 3-->
                <div class="product-card product-3">
                    <img src="../assets/img/img_not_found.png">
                    <div class="product-info">
                        <h3>Teclado mecanico</h3>
                        <p>$199</p>
                    </div>
                </div>
            </div>
        </section>

        <!------------------------------->
        <!-- 5. Barra de nav (footer)---->
        <!------------------------------->
        <?php include '../includes/footer-nav.php'; ?>
    </main>
</body>
</html>