<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - StockFlow</title>
    <!-- ---- Iconos ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
    <!-- ----- General ----- -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- ----- Header ----- -->
    <link rel="stylesheet" href="../assets/css/sales/sales-header.css">
    <!-- ----- Main ----- -->
    <link rel="stylesheet" href="../assets/css/sales/sales-main.css">
    <!-- Footer -->
    <link rel="stylesheet" href="../assets/css/footer-nav.css">
</head>
<body>

    <!------------------------->
    <!-- Header --------------->
    <!------------------------>
    <header class="sales-header">
        <!-- Botón hamburguesa-->
        <button class="sales-header_menu">
            <i class="fa-solid fa-bars" style="color: rgb(255, 255, 255);"></i>
        </button>
        <!-- Logo -->
        <div class="sales-header_title">Ventas</div>
        <!-- Botón notificaciones -->
        <button class="sales-header_plus">
            <i class="fa-solid fa-plus" style="color: rgb(255, 255, 255);"></i>
        </button>
    </header>

    <main>
        <div class="sales-main">

            <div class="sales_search">
                <input type="text" id="searchInput" placeholder="Buscar ventas..." />
            </div>

            <div class="sales-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>PRECIO</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1</td>
                            <td>Laptop HP Pavilion</td>
                            <td>$850.00</td>
                            <td>2026-03-10</td>
                        </tr>
                        <tr>
                            <td>#2</td>
                            <td>Monitor Samsung 24"</td>
                            <td>$180.50</td>
                            <td>2026-03-12</td>
                        </tr>
                        <tr>
                            <td>#3</td>
                            <td>Teclado Mecánico RGB</td>
                            <td>$65.90</td>
                            <td>2026-03-15</td>
                        </tr>
                        <tr>
                            <td>#4</td>
                            <td>Mouse Inalámbrico Logitech</td>
                            <td>$45.00</td>
                            <td>2026-03-18</td>
                        </tr>
                        <tr>
                            <td>#5</td>
                            <td>Audífonos Sony WH-1000XM5</td>
                            <td>$399.99</td>
                            <td>2026-03-20</td>
                        </tr>
                    </tbody>
                    </table>
                    
                </table>
            </div>
        </div>
    </main>

    <!-- Include -->
    <?php include '../includes/footer-nav.php'; ?>
</body>
</html>