<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    $nombre = $_SESSION['nombre'] ?? '';
    $rol = $_SESSION['rol'] ??'';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda · StockFlow</title>
    <meta name="description" content="Resumen diario de tu inventario">
    <!-- Favicon -->
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <!-- ----- Font Awesome ----- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/ayuda.css">
</head>
<body>
    <!-- ============================================
                Header
    ==============================================-->
    <header class="ayuda-header">
        <a href="../index.php">
            <span class="header-txt">Stockflow</span>
        </a>
        <a href="dashboard.php" class="btn-volver">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Volver al dashboard</span>
        </a>
    </header>

    <!-- ============================================
                Main
    ==============================================-->
    <main class="ayuda-main">
        <section class="ayuda-contenido">
            <h1>Ayuda</h1>
            <p class="ayuda-subtitulo">Hola <?= htmlspecialchars($nombre) ?>, tocá cada sección para ver cómo se usa la página.</p>

            <!-- Dashboard -->
            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-house"></i> Ayuda de Dashboard</summary>
                <div class="ayuda-texto">
                    <p>El dashboard es tu resumen del día. Lo que ves depende de tu rol.</p>
                    <?php if ($rol === 'vendedor'): ?>
                        <p><strong>Tarjetas:</strong> productos vendidos, ventas de los últimos 7 días y de los últimos 30 días.</p>
                        <p><strong>Gráfico:</strong> ves "Ventas de los últimos 7 días".</p>
                    <?php elseif ($rol === 'repositor'): ?>
                        <p><strong>Tarjetas:</strong> productos totales, stock bajo y sin stock.</p>
                        <p><strong>Gráfico:</strong> ves "Estado del stock" (normal, bajo o sin stock).</p>
                        <p><strong>Stock bajo:</strong> muestra los productos que están en el mínimo o por debajo. Para reponer, hacé click en <strong>Reponer</strong>, escribí cuántas unidades querés agregar y aceptá.</p>
                    <?php else: ?>
                        <p><strong>Tarjetas:</strong> productos totales, ventas totales y gastos del mes.</p>
                        <p><strong>Gráficos:</strong> ves "Ventas de los últimos 7 días" y "Estado del stock".</p>
                        <p><strong>Stock bajo:</strong> muestra los productos que están en el mínimo o por debajo. Para reponer, hacé click en <strong>Reponer</strong>, escribí cuántas unidades querés agregar y aceptá.</p>
                    <?php endif; ?>
                </div>
            </details>

            <!-- Inventario -->
            <?php if ($rol === 'repositor' || $rol === 'administrador'): ?>
            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-box-open"></i> Ayuda de Inventario</summary>
                <div class="ayuda-texto">
                    <p>Acá administitás los productos.</p>
                    <p><strong>Buscar:</strong> escribí en el buscador. Espera un momento y aparece un desplegable con resultados. Hacé click en uno para filtrar la tabla.</p>
                    <p><strong>Agregar producto:</strong> presioná el botón <strong>+</strong>, completá nombre, precio, precio unitario, stock, stock mínimo, categoría (de productos) y proveedor, y guardá. El stock inicial queda registrado como entrada.</p>
                    <p><strong>Editar:</strong> presioná el ícono de engranaje. Si cambiás el stock, se registra la diferencia como entrada o ajuste.</p>
                    <p><strong>Eliminar:</strong> presioná el tacho y confirmá. Es una baja lógica: el producto no se borra de la base, queda inactivo y se registra como movimiento de baja.</p>
                </div>
            </details>
            <?php endif; ?>

            <!-- Ventas -->
            <?php if ($rol === 'vendedor' || $rol === 'administrador'): ?>
            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-cart-shopping"></i> Ayuda de Ventas</summary>
                <div class="ayuda-texto">
                    <p>Es el punto de venta.</p>
                    <p><strong>1.</strong> Buscá un producto escribiendo su nombre. Aparece abajo con precio y stock.</p>
                    <p><strong>2.</strong> Hacé click en el resultado o en el botón <strong>+</strong> del catálogo para agregarlo al carrito.</p>
                    <p><strong>3.</strong> En el carrito podés subir o bajar la cantidad con <strong>+</strong> y <strong>-</strong>, o quitar el ítem con el tacho. No podés vender más unidades que el stock.</p>
                    <p><strong>4.</strong> Revisá el subtotal, el IVA (22%) y el total, y presioná <strong>Registrar venta</strong>. El stock se descuenta automáticamente.</p>
                    <p><strong>Historial:</strong> abajo ves las últimas ventas. Para anular una, presioná el tacho, confirmá y el stock vuelve a como estaba. Las anuladas no suman en los totales.</p>
                </div>
            </details>
            <?php endif; ?>

            <!-- Gastos, Reportes y Usuarios -->
            <?php if ($rol === 'administrador'): ?>
            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-receipt"></i> Ayuda de Gastos</summary>
                <div class="ayuda-texto">
                    <p><strong>Tarjetas de arriba:</strong> gastos del mes, pagos pendientes, gasto promedio y categoría que más se gastó.</p>
                    <p><strong>Nuevo gasto:</strong> presioná el botón <strong>+</strong>, completá descripción, categoría (de gastos: Alquiler, Salarios, Servicios...), monto, fecha y estado, y guardá.</p>
                    <p><strong>Estados:</strong> `pagado` ya se pagó, `pendiente` todavía no, `cancelado` no suma en los totales.</p>
                    <p><strong>Buscar:</strong> escribí en el buscador y elegí un resultado del desplegable para filtrar la lista.</p>
                    <p><strong>Editar / Eliminar:</strong> con el lápiz editás un gasto existente, con el tacho lo eliminás (confirmando antes).</p>
                </div>
            </details>

            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-file"></i> Ayuda de Reportes</summary>
                <div class="ayuda-texto">
                    <p>Unifica ventas, gastos y movimientos de stock en una sola lista.</p>
                    <p><strong>1.</strong> Elegí el tipo: Todos los eventos, Ventas, Gastos o Stock.</p>
                    <p><strong>2.</strong> Elegí el rango de fechas (Desde / Hasta).</p>
                    <p><strong>3.</strong> Presioná <strong>Generar</strong>. Arriba ves cuántos eventos hay, el rango y el total neto.</p>
                    <p><strong>Cómo leerlo:</strong> ventas suman positivo, gastos suman negativo. En stock ves por ejemplo "Salida de Laptop Gamer (-2 u.)" con el motivo debajo, como "Venta #12".</p>
                    <p><strong>Descargar PDF:</strong> presioná <strong>Descargar PDF</strong>, se abre la impresión y elegí "Guardar como PDF".</p>
                    <p><strong>Nota:</strong> las ventas anuladas y los gastos cancelados se muestran en la lista, pero <strong>no</strong> suman en el total.</p>
                </div>
            </details>

            <details class="ayuda-desplegable">
                <summary><i class="fa-solid fa-users"></i> Ayuda de Usuarios</summary>
                <div class="ayuda-texto">
                    <p><strong>Tarjetas de arriba:</strong> usuarios totales, repositores y vendedores.</p>
                    <p><strong>Nuevo usuario:</strong> presioná <strong>Nuevo usuario</strong>, completá nombre, correo, contraseña y rol, y guardá. La contraseña se guarda hasheada, nadie la ve en texto plano.</p>
                    <p><strong>Roles:</strong> `administrador` ve todo, `vendedor` vende, `repositor` maneja inventario.</p>
                    <p><strong>Buscar:</strong> escribí nombre o correo y elegí un resultado del desplegable para filtrar.</p>
                    <p><strong>Eliminar:</strong> presioná el tacho y confirmá. No podés eliminar tu propia cuenta (el botón aparece deshabilitado). Si el usuario ya hizo ventas, la base puede impedir borrarlo para cuidar el historial.</p>
                </div>
            </details>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>