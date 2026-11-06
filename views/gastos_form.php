<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit;
    }
    if (($_SESSION['rol'] ?? '') !== 'administrador') {
        header('Location: error.php?e=403');
        exit;
    }

    require_once '../dao/GastosDAO.php';
    require_once '../dao/CategoriasDAO.php';

    $categorias = (new CategoriasDAO())->getGastos();

    // Si viene ?id= es edición, si no es alta
    $id    = intval($_GET['id'] ?? 0);
    $gasto = $id > 0 ? (new GastosDAO())->getById($id) : null;

    if ($id > 0 && !$gasto) {
        header('Location: gastos.php');
        exit;
    }

    $error = isset($_GET['error']);

    $descripcion = $gasto['descripcion']  ?? '';
    $categoria = $gasto['categoria_id'] ?? '';
    $monto = $gasto['monto'] ?? '';
    $fecha = $gasto['fecha'] ?? date('Y-m-d');
    $estado = $gasto['estado'] ?? 'pendiente';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $gasto ? 'Editar gasto' : 'Nuevo gasto' ?> · StockFlow</title>
    <link rel="icon" href="../assets/img/logo/favicon_io/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets//css/gastos/gastos_form.css">
</head>
<body>
    <main>
        <header class="header-crear-usuario">
            <a href="gastos.php">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>StockFlow</span>
            </a>
        </header>

        <form class="form-crear-usuario" method="POST" action="../api/procesar_gastos.php">
            <h1><?= $gasto ? 'Editar gasto' : 'Nuevo gasto' ?></h1>

            <?php if ($error): ?>
                <p style="color:red;">Hubo un error. Revisá los datos.</p>
            <?php endif; ?>

            <?php if ($gasto): ?>
                <input type="hidden" name="id" value="<?= (int)$gasto['id'] ?>">
            <?php endif; ?>

            <section class="form-group">
                <div>
                    <label for="descripcion">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" value="<?= htmlspecialchars($descripcion) ?>" required>
                </div>

                <div>
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($categorias as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= (string)$categoria === (string)$c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="monto">Monto</label>
                    <input type="number" id="monto" name="monto" min="0" step="0.01" value="<?= htmlspecialchars($monto) ?>" required>
                </div>

                <div>
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required>
                </div>

                <div>
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" required>
                        <?php foreach (['pendiente', 'pagado', 'cancelado'] as $e): ?>
                            <option value="<?= $e ?>" <?= $estado === $e ? 'selected' : '' ?>><?= ucfirst($e) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn-crear-usuario">
                    <span>Guardar</span>
                </button>
            </section>
        </form>
    </main>
</body>
</html>