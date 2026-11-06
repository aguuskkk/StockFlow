<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['repositor', 'administrador'], true)) {
        header('Location: inventory.php');
        exit;
    }

    require_once '../dao/ProductoDAO.php';
    require_once '../dao/CategoriasDAO.php';
    require_once '../dao/ProveedorDAO.php';

    $id = intval($_GET['id'] ?? 0);
    if ($id <= 0) {
        header('Location: inventory.php');
        exit;
    }

    $dao      = new ProductoDAO();
    $producto = $dao->getById($id);

    if (!$producto) {
        header('Location: inventory.php');
        exit;
    }

    $CatDao     = new CategoriasDAO();
    $categorias = $CatDao->getProductos();

    $ProvDao    = new ProveedorDAO();
    $proveedores = $ProvDao->getAll();

    $errores = $_SESSION['form_errors'] ?? [];
    $old     = $_SESSION['form_old']    ?? [];
    unset($_SESSION['form_errors'], $_SESSION['form_old']);

    $valores = [
        'nombre' => $old['nombre'] ?? $producto['nombre'],
        'descripcion' => $old['descripcion'] ?? ($producto['descripcion'] ?? ''),
        'precio' => $old['precio'] ?? $producto['precio'],
        'precio_unitario' => $old['precio_unitario'] ?? $producto['precio_unitario'],
        'stock' => $old['stock'] ?? $producto['stock'],
        'stock_minimo' => $old['stock_minimo'] ?? $producto['stock_minimo'],
        'categoria' => $old['categoria'] ?? ($producto['categoria_id'] ?? ''),
        'proveedor' => $old['proveedor'] ?? ($producto['proveedor_id'] ?? ''),
        'etiquetas' => $old['etiquetas'] ?? ($producto['etiquetas'] ?? '')
    ];
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockflow · Editar Producto</title>
    <meta name="description" content="Editar Producto">
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/inven/inventroy_add.css">
</head>
<body>
    <header>
        <a class="header-back" href="inventory.php">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Volver</span>
        </a>
        <section class="header-title"></section>
        <section class="header-logo">
            <h1>StockFlow</h1>
        </section>
    </header>

    <main role="main">
        <!-- Contenid o -->
        <section class="content">
            <!-- Header del formulario --->
            <section class="content-header">
                <h1>Editar producto</h1>
                <p>Modifica la información del producto.</p>
            </section>

            <!-- Errores -->
            <?php if (!empty($errores)): ?>
                <div class="form-errores" role="alert">
                    <ul>
                        <?php foreach ($errores as $e): ?>
                            <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- =================
                 Mobile
            ===================-->
            <section class="mobile">
                <!-- Formulario --->
                <form action="../api/procesar_productos.php" method="post">
                    <!-- Campo oculto -->
                    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                    <!-- Nombre -->
                    <div class="form-nombre">
                        <div class="icono"><i class="fa-solid fa-tag" style="color: #8f05cf"></i></div>
                        <div class="info">
                            <label for="nombre">Nombre <span>*</span></label>
                            <input type="text" name="nombre" id="nombre" placeholder="Ej. Auriculares Bluetooth" min="0" value="<?= htmlspecialchars($valores['nombre']) ?>">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="form-descripcion">
                        <div class="icono"><i class="fa-regular fa-file-lines" style="color: #ff9100"></i></div>
                        <div class="info">
                            <label for="descripcion-mobile">Descripción <span>(Opcional)</span></label>
                            <textarea name="descripcion" id="descripcion-mobile" placeholder="Ej. Auriculares Bluetooth" ><?= htmlspecialchars($valores['descripcion']) ?></textarea>
                            <span>0/500</span>
                        </div>
                    </div>
                    <!-- Precio total/costo -->
                    <div class="form-precio">
                        <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                        <div class="info">
                            <label for="precio-mobile">Precio <span>*</span></label>
                            <input type="number" name="precio" id="precio-mobile" placeholder="Ej. 1000" min="0" step="0.01" value="<?= htmlspecialchars($valores['precio']) ?>">
                        </div>
                    </div>
                    <!-- Precio por unidad -->
                    <div class="form-precio-unidad">
                        <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                        <div class="info">
                            <label for="precio_unitario-mobile">Precio unitario <span>*</span></label>
                            <input type="number" name="precio_unitario" id="precio_unitario-mobile" placeholder="Ej. 100" min="0" step="0.01" value="<?= htmlspecialchars($valores['precio_unitario']) ?>">
                        </div>
                    </div>
                    <!-- Stock -->
                    <div class="form-stock">
                        <div class="icono"><i class="fa-solid fa-box" style="color: #4400ff"></i></div>
                        <div class="info">
                            <label for="stock-mobile">Stock <span>*</span></label>
                            <input type="number" name="stock" id="stock-mobile" placeholder="Ej. 100" min="0" value="<?= htmlspecialchars($valores['stock']) ?>">
                        </div>
                    </div>
                    <!-- Stock mínimo -->
                    <div class="form-stock-minimo">
                        <div class="icono"><i class="fa-regular fa-bell" style="color: rgb(255, 81, 0);"></i></div>
                        <div class="info">
                            <label for="stock_minimo-mobile">Stock mínimo <span>*</span></label>
                            <input type="number" name="stock_minimo" id="stock_minimo-mobile" placeholder="Ej. 10" min="0" value="<?= htmlspecialchars($valores['stock_minimo']) ?>">
                            <span>Cantidad mínima antes de alertar por falta de stock.</span>
                        </div>
                    </div>
                    <!-- Categoría -->
                    <div class="form-categoria">
                        <div class="icono"><i class="fa-solid fa-table-cells-large" style="color: rgb(143, 27, 221);"></i></div>
                        <div class="info">
                            <label for="categoria-mobile">Categoría <span>*</span></label>
                            <select name="categoria" id="categoria-mobile" required>
                                <option value="">Selecciona una opción</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= ((string)$valores['categoria'] === (string)$c['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Proveedor -->
                    <div class="form-proveedor">
                        <div class="icono"><i class="fa-solid fa-user" style="color: rgba(13, 185, 99, 0.75);"></i></div>
                        <div class="info">
                            <label for="proveedor-mobile">Proveedor <span>*</span></label>
                            <select name="proveedor" id="proveedor-mobile" required>
                                <option value="">Selecciona una opción</option>
                                <?php foreach ($proveedores as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= ((string)$valores['proveedor'] === (string)$p['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Etiquetas -->
                    <div class="form-etiquetas">
                        <div class="icono"><i class="fa-solid fa-tag" style="color: rgba(206, 50, 50, 0.78);"></i></div>
                        <div class="info">
                            <label for="etiquetas-input-mobile">Etiquetas <span>(Opcional)</span></label>
                            <input type="text" id="etiquetas-input-mobile" placeholder="Escribe una etiqueta y presiona SPACE">
                            <input type="hidden" name="etiquetas" value="<?= htmlspecialchars($valores['etiquetas']) ?>">
                            <div class="etiquetas-chips" id="etiquetas-chips-mobile"></div>
                        </div>
                    </div>
                    <!-- Botones -->
                    <div class="form-botones">
                        <button type="submit" class="btn-submit">
                            <i class="fa-regular fa-floppy-disk" style="color: white;"></i>
                            Guardar Cambios
                        </button>
                        <a href="inventory.php" class="btn-reset">Cancelar</a>
                    </div>
                </form>
            </section>
            <!-- =================
                 Desktop
            ===================-->
            <section class="desktop">
                <form action="../api/procesar_productos.php" method="post">
                    <!-- Campo oculto -->
                    <input type="hidden" name="id" value="<?= (int) $producto['id'] ?>">
                    <!-- Conjunto 1: Nombre, Descripción, Categoría y Proveedor -->
                    <div class="conjunto-1">
                        <div class="conjunto-nom-des">
                            <div class="form-nombre">
                                <div class="icono"><i class="fa-solid fa-tag" style="color: #8f05cf"></i></div>
                                <div class="info">
                                    <label for="nombre">Nombre <span>*</span></label>
                                    <input type="text" name="nombre" id="nombre" placeholder="Ej. Auriculares Bluetooth" value="<?= htmlspecialchars($valores['nombre']) ?>" required>
                                </div>
                            </div>
                            <div class="form-descripcion">
                                <div class="icono"><i class="fa-regular fa-file-lines" style="color: #ff9100"></i></div>
                                <div class="info">
                                    <label for="descripcion">Descripción <span>(Opcional)</span></label>
                                    <textarea name="descripcion" id="descripcion" placeholder="Ej. Auriculares Bluetooth"><?= htmlspecialchars($valores['descripcion']) ?></textarea>
                                    <span>0/500</span>
                                </div>
                            </div>
                        </div>
                        <div class="conjunto-cat-prov">
                            <div class="form-categoria">
                                <div class="icono"><i class="fa-solid fa-table-cells-large" style="color: rgb(143, 27, 221);"></i></div>
                                <div class="info">
                                    <label for="categoria">Categoría <span>*</span></label>
                                    <select name="categoria" id="categoria" required>
                                        <option value="">Selecciona una opción</option>
                                        <?php foreach ($categorias as $c): ?>
                                            <option value="<?= $c['id'] ?>" <?= ((string)$valores['categoria'] === (string)$c['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-proveedor">
                                <div class="icono"><i class="fa-solid fa-user" style="color: rgba(13, 185, 99, 0.75);"></i></div>
                                <div class="info">
                                    <label for="proveedor">Proveedor <span>*</span></label>
                                    <select name="proveedor" id="proveedor" required>
                                        <option value="">Selecciona una opción</option>
                                        <?php foreach ($proveedores as $p): ?>
                                            <option value="<?= $p['id'] ?>" <?= ((string)$valores['proveedor'] === (string)$p['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($p['nombre']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Conjunto 2: Precios y Stock -->
                    <div class="conjunto-2">
                        <div class="form-precio">
                            <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                            <div class="info">
                                <label for="precio">Precio <span>*</span></label>
                                <input type="number" name="precio" id="precio" placeholder="Ej. 1000" min="0" step="0.01" value="<?= htmlspecialchars($valores['precio']) ?>" required>
                            </div>
                        </div>
                        <div class="form-precio-unidad">
                            <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                            <div class="info">
                                <label for="precio_unitario">Precio unitario <span>*</span></label>
                                <input type="number" name="precio_unitario" id="precio_unitario" placeholder="Ej. 100" min="0" step="0.01" value="<?= htmlspecialchars($valores['precio_unitario']) ?>" required>
                            </div>
                        </div>
                        <div class="form-stock">
                            <div class="icono"><i class="fa-solid fa-box" style="color: #4400ff"></i></div>
                            <div class="info">
                                <label for="stock">Stock <span>*</span></label>
                                <input type="number" name="stock" id="stock" placeholder="Ej. 100" min="0" value="<?= htmlspecialchars($valores['stock']) ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Conjunto 3: Stock Mínimo y Etiquetas -->
                    <div class="conjunto-3">
                        <div class="form-stock-minimo">
                            <div class="icono"><i class="fa-regular fa-bell" style="color: rgb(255, 81, 0);"></i></div>
                            <div class="info">
                                <label for="stock_minimo">Stock mínimo <span>*</span></label>
                                <input type="number" name="stock_minimo" id="stock_minimo" placeholder="Ej. 10" min="0" value="<?= htmlspecialchars($valores['stock_minimo']) ?>" required>
                                <span>Cantidad mínima antes de alertar por falta de stock.</span>
                            </div>
                        </div>
                        <div class="form-etiquetas">
                            <div class="icono"><i class="fa-solid fa-tag" style="color: rgba(206, 50, 50, 0.78);"></i></div>
                            <div class="info">
                                <label for="etiquetas-input">Etiquetas <span>(Opcional)</span></label>
                                <input type="text" id="etiquetas-input" placeholder="Escribe una etiqueta y presiona SPACE">
                                <input type="hidden" name="etiquetas" value="<?= htmlspecialchars($valores['etiquetas']) ?>">
                                <div class="etiquetas-chips" id="etiquetas-chips"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Conjunto 4: Tip y Botones -->
                    <div class="conjunto-4">
                        <div class="form-tip">
                            <h2>¡Tip!</h2>
                            <p>Modifica los campos necesarios para mantener tu inventario al día.</p>
                        </div>
                        <div class="form-botones">
                            <a href="inventory.php" class="btn-reset">Cancelar</a>
                            <button type="submit" class="btn-submit">
                                <i class="fa-regular fa-floppy-disk" style="color: white;"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </section>
    </main>


    <script src="../assets/js/inven/etiquetas_productos.js"></script>
</body>
</html>