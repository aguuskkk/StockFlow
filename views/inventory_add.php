<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }

    if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['repositor', 'administrador'], true)) {
        header('Location: error.php?e=403');
        exit;
    }

    require_once '../dao/ProductoDAO.php';
    require_once '../dao/CategoriasDAO.php';
    require_once '../dao/ProveedorDAO.php';

    $CatDao  = new CategoriasDAO();
    $categorias = $CatDao->getProductos();

    $ProvDao = new ProveedorDAO();
    $proveedores = $ProvDao->getAll();

    $errores = $_SESSION['form_errors'] ?? [];
    $old     = $_SESSION['form_old']    ?? [];
    unset($_SESSION['form_errors'], $_SESSION['form_old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockflow · Nuevo Producto</title>
    <meta name="description" content="Nuevo Producto">
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/inven/inventroy_add.css">
</head>
<body>
    <!-- ==================
            HEADER
    ====================-->
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

    <!-- ==================
            Main
    ====================-->
    <main role="main">
        <!-- Contenido -->
        <section class="content">
            <!-- Header de la pagina -->
            <section class="content-header">
                <h1>Nuevo producto</h1>
                <p>Completa la información para agregar un nuevo producto.</p>
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

            <!-- ==================
                    Mobile
            ====================-->
            <section class="mobile">
                <!-- Formulario -->
                <form action="../api/procesar_productos.php" method="post">
                    <!-- Nombre -->
                    <div class="form-nombre">
                        <div class="icono"><i class="fa-solid fa-tag" style="color: #8f05cf"></i></div>
                        <div class="info">
                            <label for="nombre">Nombre <span>*</span></label>
                            <input type="text" name="nombre" id="nombre" placeholder="Ej. Auriculares Bluetooth" min="0" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Descripcion (no obligatoria) -->
                    <div class="form-descripcion">
                        <div class="icono"><i class="fa-regular fa-file-lines" style="color: #ff9100"></i></div>
                        <div class="info">
                            <label for="descripcion">Descripción <span>(Opcional)</span></label>
                            <textarea name="descripcion" id="descripcion" placeholder="Ej. Auriculares Bluetooth"><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
                            <span>0/500</span>
                        </div>
                    </div>

                    <!-- Precio total/costo -->
                    <div class="form-precio">
                        <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                        <div class="info">
                            <label for="precio">Precio <span>*</span></label>
                            <input type="number" name="precio" id="precio" placeholder="Ej. 1000" title="Precio total del producto" min="0" value="<?= htmlspecialchars($old['precio'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Precio por unidad -->
                    <div class="form-precio-unidad">
                        <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                        <div class="info">
                            <label for="precio-unidad">Precio unitario <span>*</span></label>
                            <input type="number" name="precio_unitario" id="precio_unitario" placeholder="Ej. 100" title="Precio por unidad del producto" min="0" step="0.01" value="<?= htmlspecialchars($old['precio_unitario'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="form-stock">
                        <div class="icono"><i class="fa-solid fa-box" style="color: #4400ff"></i></div>
                        <div class="info">
                            <label for="stock">Stock <span>*</span></label>
                            <input type="number" name="stock" id="stock" placeholder="Ej. 100" min="0" value="<?= htmlspecialchars($old['stock'] ?? '') ?>" required>
                        </div>
                    </div>

                    <!-- Stock minimo -->
                    <div class="form-stock-minimo">
                        <div class="icono"><i class="fa-regular fa-bell" style="color: rgb(255, 81, 0);"></i></div>
                        <div class="info">
                            <label for="stock_minimo">Stock mínimo <span>*</span></label>
                            <input type="number" name="stock_minimo" id="stock_minimo" placeholder="Ej. 10" min="0" value="<?= htmlspecialchars($old['stock_minimo'] ?? '') ?>" required>
                            <span>Cantidad minima antes de alertar por falta de stock.</span>
                        </div>
                    </div>

                    <!-- Categoria -->
                    <div class="form-categoria">
                        <div class="icono"><i class="fa-solid fa-table-cells-large" style="color: rgb(143, 27, 221);"></i></div>
                        <div class="info">
                            <label for="categoria">Categoria <span>*</span></label>
                            <select name="categoria" id="categoria" required>
                                <option value="">Selecciona una opción</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= ($old['categoria'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Proveedor -->
                    <div class="form-proveedor">
                        <div class="icono"><i class="fa-solid fa-user" style="color: rgba(13, 185, 99, 0.75);"></i></div>
                        <div class="info">
                            <label for="proveedor">Proveedor <span>*</span></label>
                            <select name="proveedor" id="proveedor" required>
                                <option value="">Selecciona una opción</option>
                                <?php foreach ($proveedores as $p): ?>
                                    <option value="<?= $p['id'] ?>" <?= ($old['proveedor'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Etiquetas -->
                    <div class="form-etiquetas">
                        <div class="icono"><i class="fa-solid fa-tag" style="color: rgba(206, 50, 50, 0.78);"></i></div>
                        <div class="info">
                            <label for="etiquetas-input-mobile">Etiquetas <span>(Opcional)</span></label>
                            <input type="text" id="etiquetas-input-mobile" placeholder="Escribe una etiqueta y presiona SPACE para agregarla" autocomplete="off">
                            <div class="etiquetas-chips" id="etiquetas-chips-mobile"></div>
                            <input type="hidden" name="etiquetas" id="etiquetas" value="<?= htmlspecialchars($old['etiquetas'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="form-botones">
                        <button type="submit" class="btn-submit" aria-label="Agregar producto"><i class="fa-regular fa-floppy-disk" style="color: rgb(255, 255, 255);"></i>Guardar Producto</button>
                        <button type="reset" id="cancel-btn" class="btn-reset" aria-label="Borrar producto">Cancelar</button>
                    </div>
                </form>
            </section>

            <!-- ==================
                    Desktop
            ====================-->
            <section class="desktop">
                <!-- Formulario -->
                <form action="../api/procesar_productos.php" method="post">
                    <!-- Primero conjunto de elementos -->
                    <div class="conjunto-1">
                        <!-- Nombre y descripcion --->
                        <div class="conjunto-nom-des">
                            <div class="form-nombre">
                                <div class="icono"><i class="fa-solid fa-tag" style="color: #8f05cf"></i></div>
                                <div class="info">
                                    <label for="nombre">Nombre <span>*</span></label>
                                    <input type="text" name="nombre" id="nombre" placeholder="Ej. Auriculares Bluetooth" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="form-descripcion">
                                <div class="icono"><i class="fa-regular fa-file-lines" style="color: #ff9100"></i></div>
                                <div class="info">
                                    <label for="descripcion">Descripción <span>(Opcional)</span></label>
                                    <textarea name="descripcion" id="descripcion" placeholder="Ej. Auriculares Bluetooth"><?= htmlspecialchars($old['descripcion'] ?? '') ?></textarea>
                                    <span>0/500</span>
                                </div>
                            </div>
                        </div>
                        <!-- Categoria y proveedor -->
                        <div class="conjunto-cat-prov">
                            <div class="form-categoria">
                                <div class="icono"><i class="fa-solid fa-table-cells-large" style="color: rgb(143, 27, 221);"></i></div>
                                <div class="info">
                                    <label for="categoria">Categoria <span>*</span></label>
                                    <select name="categoria" id="categoria" required>
                                        <option value="">Selecciona una opción</option>
                                        <?php foreach ($categorias as $c): ?>
                                            <option value="<?= $c['id'] ?>" <?= ($old['categoria'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre']) ?></option>
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
                                            <option value="<?= $p['id'] ?>" <?= ($old['proveedor'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= htmlspecialchars($p['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Segundo Conjunto de elemento --->
                    <div class="conjunto-2">
                        <!-- Precio --->
                        <div class="form-precio">
                            <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                            <div class="info">
                                <label for="precio">Precio <span>*</span></label>
                                <input type="number" name="precio" id="precio" placeholder="Ej. 1000" title="Precio total del producto" min="0" value="<?= htmlspecialchars($old['precio'] ?? '') ?>" required>
                            </div>
                        </div>
                        <!-- Precio por unidad -->
                        <div class="form-precio-unidad">
                            <div class="icono"><i class="fa-solid fa-dollar-sign" style="color: #089903"></i></div>
                            <div class="info">
                                <label for="precio-unidad">Precio unitario <span>*</span></label>
                                <input type="number" name="precio_unitario" id="precio_unitario" placeholder="Ej. 100" title="Precio por unidad del producto" min="0" step="0.01" value="<?= htmlspecialchars($old['precio_unitario'] ?? '') ?>" required>
                            </div>
                        </div>
                        <!-- Stock -->
                        <div class="form-stock">
                            <div class="icono"><i class="fa-solid fa-box" style="color: #4400ff"></i></div>
                            <div class="info">
                                <label for="stock">Stock <span>*</span></label>
                                <input type="number" name="stock" id="stock" placeholder="Ej. 100" min="0" value="<?= htmlspecialchars($old['stock'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tercer conjunto de elemntos -->
                    <div class="conjunto-3">
                        <!-- Stock minimo -->
                        <div class="form-stock-minimo">
                            <div class="icono"><i class="fa-regular fa-bell" style="color: rgb(255, 81, 0);"></i></div>
                            <div class="info">
                                <label for="stock_minimo">Stock mínimo <span>*</span></label>
                                <input type="number" name="stock_minimo" id="stock_minimo" placeholder="Ej. 10" min="0" value="<?= htmlspecialchars($old['stock_minimo'] ?? '') ?>" required>
                                <span>Cantidad minima antes de alertar por falta de stock.</span>
                            </div>
                        </div>
                        <!-- Etiquetas -->
                        <div class="form-etiquetas">
                            <div class="icono"><i class="fa-solid fa-tag" style="color: rgba(206, 50, 50, 0.78);"></i></div>
                            <div class="info">
                                <label for="etiquetas-input">Etiquetas <span>(Opcional)</span></label>
                                <input type="text" id="etiquetas-input" placeholder="Escribe una etiqueta y presiona SPACE para agregarla" autocomplete="off">
                                <div class="etiquetas-chips" id="etiquetas-chips"></div>
                                <input type="hidden" name="etiquetas" id="etiquetas" value="<?= htmlspecialchars($old['etiquetas'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Cuarto conjunto de elementos -->
                    <div class="conjunto-4">
                        <div class="form-tip">
                            <h2>¡Tip!</h2>
                            <p>Mientras más información agregues, más fácil será encontrar tu producto.</p>
                        </div>
                        <div class="form-botones">
                            <button type="reset" class="btn-reset" aria-label="Borrar producto">Cancelar</button>
                            <button type="submit" class="btn-submit" aria-label="Agregar producto">
                                <i class="fa-regular fa-floppy-disk" style="color: rgb(255, 255, 255);"></i>
                                Guardar Producto
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