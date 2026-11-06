<?php
require_once __DIR__ . '/../config/database.php';

class ProductoDAO {

    // 
    private const SELECT_BASE = "
        SELECT p.*,
               c.nombre  AS categoria,
               pr.nombre AS proveedor
        FROM productos p
        LEFT JOIN categorias  c  ON c.id  = p.categoria_id
        LEFT JOIN proveedores pr ON pr.id = p.proveedor_id
    ";

    // Obtener todos los productos
    public function getAll() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " WHERE p.activo = 1 ORDER BY p.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare(self::SELECT_BASE . " WHERE p.id = :id AND p.activo = 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscar($termino) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare(
            self::SELECT_BASE . "
             WHERE p.activo = 1
               AND (p.nombre    LIKE :t
                 OR p.etiquetas LIKE :t
                 OR c.nombre    LIKE :t
                 OR pr.nombre   LIKE :t)
             ORDER BY p.id DESC"
        );
        $stmt->execute([':t' => '%' . $termino . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($nombre, $descripcion, $precio, $precio_unitario, $stock, $stock_minimo, $categoria_id, $proveedor_id, $etiquetas, $pdo = null) {
        if (!$pdo) {
            $pdo = getConexion();
        }
        $stmt = $pdo->prepare(
            "INSERT INTO productos
                (nombre, descripcion, precio, precio_unitario, stock, stock_minimo, categoria_id, proveedor_id, etiquetas)
             VALUES
                (:nombre, :descripcion, :precio, :precio_unitario, :stock, :stock_minimo, :categoria_id, :proveedor_id, :etiquetas)"
        );

        $stmt->execute([
            ':nombre'          => $nombre,
            ':descripcion'     => $descripcion,
            ':precio'          => $precio,
            ':precio_unitario' => $precio_unitario,
            ':stock'           => $stock,
            ':stock_minimo'    => $stock_minimo,
            ':categoria_id'    => empty($categoria_id) ? null : (int) $categoria_id,
            ':proveedor_id'    => empty($proveedor_id) ? null : (int) $proveedor_id,
            ':etiquetas'       => $etiquetas
        ]);

        return (int)$pdo->lastInsertId();
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $precio_unitario, $stock, $stock_minimo, $categoria_id, $proveedor_id, $etiquetas, $pdo = null) {
        if (!$pdo) {
            $pdo = getConexion();
        }
        $stmt = $pdo->prepare(
            "UPDATE productos SET
                nombre          = :nombre,
                descripcion     = :descripcion,
                precio          = :precio,
                precio_unitario = :precio_unitario,
                stock           = :stock,
                stock_minimo    = :stock_minimo,
                categoria_id    = :categoria_id,
                proveedor_id    = :proveedor_id,
                etiquetas       = :etiquetas
             WHERE id = :id"
        );

        return $stmt->execute([
            ':id'              => $id,
            ':nombre'          => $nombre,
            ':descripcion'     => $descripcion,
            ':precio'          => $precio,
            ':precio_unitario' => $precio_unitario,
            ':stock'           => $stock,
            ':stock_minimo'    => $stock_minimo,
            ':categoria_id'    => empty($categoria_id) ? null : (int) $categoria_id,
            ':proveedor_id'    => empty($proveedor_id) ? null : (int) $proveedor_id,
            ':etiquetas'       => $etiquetas
        ]);
    }

    public function eliminar($id, $usuarioId = null, $pdo = null) {
        $esPropio = ($pdo === null);
        if ($esPropio) {
            $pdo = getConexion();
        }

        if ($esPropio) {
            $pdo->beginTransaction();
        }

        try {
            $stmt = $pdo->prepare("SELECT stock FROM productos WHERE id = :id AND activo = 1 FOR UPDATE");
            $stmt->execute([':id' => (int)$id]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$producto) {
                if ($esPropio) {
                    $pdo->rollBack();
                }
                return false;
            }

            $stockActual = (int)$producto['stock'];

            $stmt = $pdo->prepare("UPDATE productos SET activo = 0 WHERE id = :id");
            $stmt->execute([':id' => (int)$id]);

            require_once __DIR__ . '/MovimientosDAO.php';
            $movDAO = new MovimientosDAO();
            $movDAO->registrar(
                (int)$id,
                'baja',
                -$stockActual,
                $stockActual,
                0,
                $usuarioId !== null ? (int)$usuarioId : null,
                'Baja lógica (desactivado)',
                $pdo
            );

            if ($esPropio) {
                $pdo->commit();
            }
            return true;
        } catch (Exception $e) {
            if ($esPropio && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    // Obtener productos con bajo stock
    public function getStockBajo() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            self::SELECT_BASE . "
             WHERE p.activo = 1 AND p.stock <= p.stock_minimo
             ORDER BY p.stock ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener productos sin stock
    public function getSinStock() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            self::SELECT_BASE . "
             WHERE p.activo = 1 AND p.stock = 0
             ORDER BY p.stock ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Paginado
    public function getPaginado($pagina = 1, $porPagina = 10) {
        $pdo    = getConexion();
        $offset = ($pagina - 1) * $porPagina;

        $stmt = $pdo->prepare(
            self::SELECT_BASE . "
             WHERE p.activo = 1
             ORDER BY p.id DESC
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit',  $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,    PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTotal() {
        $pdo = getConexion();
        return (int) $pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1")->fetchColumn();
    }

    // Resumen para las charts
    public function getResumenStock() {
        $pdo = getConexion();

        $total = (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1")->fetchColumn();
        $sin = (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1 AND stock = 0")->fetchColumn();
        $bajo = (int)$pdo->query("SELECT COUNT(*) FROM productos WHERE activo = 1 AND stock > 0 AND stock <= stock_minimo")->fetchColumn();
        $normal = $total - $bajo - $sin;

        return ['normal' => $normal, 'bajo' => $bajo, 'sin' => $sin];
    }
}
