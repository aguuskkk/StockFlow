<?php
session_start();
require_once __DIR__ . '/../dao/ProductoDAO.php';

// Autorización
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['repositor', 'administrador'], true)) {
    header('Location: ../views/login.php');
    exit;
}

// leer 
$nombre = trim($_POST['nombre'] ?? '');
$id = intval($_POST['id'] ?? 0);
$descripcion = trim($_POST['descripcion'] ?? '');
$precio = $_POST['precio'] ?? '';
$precio_unitario = $_POST['precio_unitario'] ?? '';
$stock = $_POST['stock'] ?? '';
$stock_minimo = $_POST['stock_minimo'] ?? '';
$categoria = intval($_POST['categoria'] ?? 0);
$proveedor = intval($_POST['proveedor'] ?? 0);
$etiquetas = trim($_POST['etiquetas'] ?? '');

// Validaciones
$errores = [];

if ($nombre === '') $errores[] = 'El nombre del producto no puede estar vacío'; // El nombre es obligatorio
if ($categoria <= 0) $errores[] = 'La categoría es obligatoria.'; // La categoría es obligatoria
if ($proveedor <= 0) $errores[] = 'El proveedor es obligatorio.'; // El proveedor es obligatorio

// El precio es obligatorio y debe ser un número mayor o igual a 0
if ($precio === '') {
    $errores[] = 'El precio es obligatorio.';
} elseif (!is_numeric($precio) || floatval($precio) < 0) {
    $errores[] = 'El precio debe ser un número mayor o igual a 0.';
}

// El precio unitario es obligatorio y debe ser un número mayor o igual a 0
if ($precio_unitario === '') {
    $errores[] = 'El precio unitario es obligatorio.';
} elseif (!is_numeric($precio_unitario) || floatval($precio_unitario) < 0) {
    $errores[] = 'El precio unitario debe ser un número mayor o igual a 0.';
}

// El stock es obligatorio y debe ser un entero mayor o igual a 0
if ($stock === '') {
    $errores[] = 'El stock es obligatorio.';
} elseif (!is_numeric($stock) || intval($stock) < 0) {
    $errores[] = 'El stock debe ser un entero mayor o igual a 0.';
}

// El stock mínimo es obligatorio y debe ser un entero mayor o igual a 0
if ($stock_minimo === '') {
    $errores[] = 'El stock mínimo es obligatorio.';
} elseif (!is_numeric($stock_minimo) || intval($stock_minimo) < 0) {
    $errores[] = 'El stock mínimo debe ser un entero mayor o igual a 0.';
}

if (!empty($errores)) {
    $_SESSION['form_errors'] = $errores;
    $_SESSION['form_old']    = $_POST;
    
    if ($id > 0) {
        header("Location: ../views/inventory_edit.php?id={$id}&error=1");
    } else {
        header('Location: ../views/inventory_add.php?error=1');
    }
    exit;
}

$dao = new ProductoDAO();
$pdo = getConexion();

try {
    if ($id > 0) {
        // Modo EDICIÓN
        $actual = $dao->getById($id);
        $stockAnterior = (int)($actual['stock'] ?? 0);
        $stockNuevo = intval($stock);

        $pdo->beginTransaction();

        $ok = $dao->actualizar(
            $id,
            $nombre,
            $descripcion,
            floatval($precio),
            floatval($precio_unitario),
            intval($stock),
            intval($stock_minimo),
            $categoria,
            $proveedor,
            $etiquetas,
            $pdo
        );

        if (!$ok) {
            $pdo->rollBack();
            $_SESSION['form_errors'] = ['No se pudo actualizar el producto.'];
            $_SESSION['form_old']    = $_POST;
            header("Location: ../views/inventory_edit.php?id={$id}&error=1");
            exit;
        }

        $diferencia = $stockNuevo - $stockAnterior;

        // Solo registrar si el stock cambió
        if ($diferencia !== 0) {
            require_once __DIR__ . '/../dao/MovimientosDAO.php';
            $movDAO = new MovimientosDAO();

            $tipo = ($diferencia > 0) ? 'entrada' : 'ajuste';

            $movDAO->registrar(
                $id,
                $tipo,
                $diferencia,
                $stockAnterior,
                $stockNuevo,
                (int)$_SESSION['usuario_id'],
                'Ajuste manual',
                $pdo
            );
        }

        $pdo->commit();
        header('Location: ../views/inventory.php?ok=editado');
        exit;
    } else {
        // Modo ALTA (nuevo producto)
        $pdo->beginTransaction();

        $nuevoId = $dao->insertar(
            $nombre,
            $descripcion,
            floatval($precio),
            floatval($precio_unitario),
            intval($stock),
            intval($stock_minimo),
            $categoria,
            $proveedor,
            $etiquetas,
            $pdo
        );

        if (!$nuevoId) {
            $pdo->rollBack();
            header('Location: ../views/inventory_add.php?error=1');
            exit;
        }

        // Registrar entrada inicial de stock
        require_once __DIR__ . '/../dao/MovimientosDAO.php';
        $movDAO = new MovimientosDAO();

        $stockNuevo = intval($stock);

        $movDAO->registrar(
            $nuevoId,
            'entrada',
            $stockNuevo,
            0,
            $stockNuevo,
            (int)$_SESSION['usuario_id'],
            'Alta de producto',
            $pdo
        );

        $pdo->commit();
        header('Location: ../views/inventory.php?ok=1');
        exit;
    }
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    if ($id > 0) {
        $_SESSION['form_errors'] = ['Error en la base de datos: ' . $e->getMessage()];
        $_SESSION['form_old']    = $_POST;
        header("Location: ../views/inventory_edit.php?id={$id}&error=1");
    } else {
        header('Location: ../views/inventory_add.php?error=1');
    }
}

exit;

?>