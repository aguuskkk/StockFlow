<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - StockFlow</title>
    <!-- ---- Iconos ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- ----- General ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- -----  Header ----- -->
     <link rel="stylesheet" href="../assets/css/inventory/inventory-header.css">
    <!-- Inventory cards -->
    <link rel="stylesheet" href="../assets/css/inventory/inventory-cards.css">
    <!-- Footer -->
    <link rel="stylesheet" href="../assets/css/footer-nav.css">
</head>
<body>
    <!------------------------->
    <!-- Header --------------->
    <!--------------.---------->
    <header class="inventory-header">
        <!-- Botón hamburguesa-->
        <button class="inventory-header_menu">
            <i class="fa-solid fa-bars" style="color: rgb(255, 255, 255);"></i>
        </button>
        <!-- Logo -->
        <div class="inventory_title">Inventario</div>
        <!-- Botón agregar -->
        <button class="inventory-header_plus">
            <i class="fa-solid fa-plus" style="color: rgb(255, 255, 255);"></i>
        </button>
    </header>
    
    <!----------------------->
    <!-- Main --------------->
    <!----------------------->
    <main>
        <!-- Contendor-->
        <section class="container">
            <!------------------------------>
            <!-- 1. Buscador --------------->
            <!------------------------------>
            <div class="inventory_search">
                <input type="text" id="searchInput" placeholder="Buscar productos..." />
            </div>

            <!----------------------------->
            <!-- 2. Filtros --------------->
            <!----------------------------->
            <div class="inventory_filter">
                <!-- Orden -->
                <button class="sortBtn"><i class="fa-solid fa-border-all" style="color: rgb(255, 255, 255);"></i></button>
                <!-- Filtrar por... -->
                <button class="filterBtn"><i class="fa-solid fa-filter" style="color: rgb(0, 0, 0);"></i></button>
            </div>

            <!---------------------------------------->
            <!-- 3. Tarjetas productos --------------->
            <!---------------------------------------->
            <div class="invetory_cards">
                <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>
                 <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>
                 <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>
                 <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>
                 <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>

                 <!-- Card-->
                <div class="card">
                    <!-- Imagen de referencia del producto-->
                    <img src="../assets/img/img_not_found.png" alt="imagen de referencia">
                    <!-- Info del producto-->
                    <div class="card-info">
                        <h3>Producto</h3>
                        <div class="price">$ 850.00</div>
                        <div class="stock">Stock: <span>5</span> uds</div>
                    </div>
                    <!-- Acciones-->
                    <div class="card-actions">
                        <!-- Editar producto-->
                        <button class="editBtn"><i class="fa-solid fa-pen-to-square" style="color: rgb(0, 0, 0);"></i></button>
                        <!-- Elimianr producto -->
                        <button class="deleteBtn"><i class="fa-solid fa-trash-can" style="color: rgb(0, 0, 0);"></i></button>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Include -->
    <?php include '../includes/footer-nav.php'; ?>
</body>
</html>