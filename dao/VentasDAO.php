<?php 
require_once __DIR__ . '/../config/database.php';

class VentasDAO {

    // Solo seleccionamos lo que hay en la tabla ventas
    private const SELECT_BASE = "
        SELECT v.*
        FROM ventas v
    ";

    // Obtener todas las ventas
    public function getAll() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " WHERE v.estado != 'anulada' ORDER BY v.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener las ventas de los últimos 7 días
    public function getUltimos7Dias() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            self::SELECT_BASE . "
                WHERE v.fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND v.estado != 'anulada'
                ORDER BY v.fecha DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    // Obtener las ventas de los últimos 30 días
    public function getUltimos30Dias() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            self::SELECT_BASE . "
                WHERE v.fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND v.estado != 'anulada'
                ORDER BY v.fecha DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductosMasVendidosUltimos7Dias() {
            $pdo = getConexion();

            $sql = "
                SELECT
                    p.id,
                    p.nombre,
                    p.precio_unitario,
                    p.stock,
                    SUM(dv.cantidad) AS total_vendido
                FROM ventas v
                INNER JOIN detalle_ventas dv
                    ON dv.venta_id = v.id
                INNER JOIN productos p
                    ON p.id = dv.producto_id
                WHERE v.fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND v.fecha <= NOW()
                AND v.estado != 'anulada'
                GROUP BY
                    p.id,
                    p.nombre,
                    p.precio_unitario,
                    p.stock
                ORDER BY total_vendido DESC, p.nombre ASC
                LIMIT 4
            ";

            $stmt = $pdo->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


    public function getHistorialDeVentas() {
        $pdo = getConexion();

        $sql = "
            SELECT
                v.id AS venta_id,
                GROUP_CONCAT(CONCAT(p.nombre, ' x', dv.cantidad) SEPARATOR ', ') AS productos,
                SUM(dv.cantidad) AS cantidad,
                v.total,
                v.fecha,
                v.estado
            FROM ventas v
            INNER JOIN detalle_ventas dv ON dv.venta_id = v.id
            INNER JOIN productos p       ON p.id = dv.producto_id
            GROUP BY v.id, v.total, v.fecha, v.estado
            ORDER BY v.fecha DESC, v.id DESC
            LIMIT 50
        ";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Para anular pues :V 
    public function anular($id, $usuarioId = null) {
        $pdo = getConexion();
        
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE ventas SET estado = 'anulada' WHERE id = :id AND estado != 'anulada'");
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() === 0) {
                $pdo->rollBack();
                return false;
            }

            $stmt = $pdo->prepare("
                UPDATE productos p
                INNER JOIN detalle_ventas dv ON dv.producto_id = p.id
                SET p.stock = p.stock + dv.cantidad
                WHERE dv.venta_id = :id
            ");
            $stmt->execute([':id' => $id]);

            // Registrar movimiento de entrada por cada producto devuelto
            require_once __DIR__ . '/../dao/MovimientosDAO.php';
            $movDAO = new MovimientosDAO();

            $q = $pdo->prepare("
                SELECT dv.producto_id, dv.cantidad, p.stock AS stock_nuevo
                FROM detalle_ventas dv
                INNER JOIN productos p ON p.id = dv.producto_id
                WHERE dv.venta_id = :id
            ");
            $q->execute([':id' => $id]);

            foreach ($q->fetchAll(PDO::FETCH_ASSOC) as $r) {
                $stockNuevo = (int)$r['stock_nuevo'];
                $cantidad   = (int)$r['cantidad'];

                $movDAO->registrar(
                    (int)$r['producto_id'],
                    'entrada',
                    $cantidad,
                    $stockNuevo - $cantidad,
                    $stockNuevo,
                    $usuarioId !== null ? (int)$usuarioId : null,
                    'Anulación venta #' . $id,
                    $pdo
                );
            }

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    // Ventas en rango de fechas para reportes
    public function getRango($desde = null, $hasta = null) {
        $pdo = getConexion();

        $sql = "
            SELECT
                v.id AS venta_id,
                GROUP_CONCAT(CONCAT(p.nombre, ' x', dv.cantidad) SEPARATOR ', ') AS productos,
                SUM(dv.cantidad) AS cantidad,
                v.total,
                v.fecha,
                v.estado
            FROM ventas v
            INNER JOIN detalle_ventas dv ON dv.venta_id = v.id
            INNER JOIN productos p ON p.id = dv.producto_id
        ";

        $where = [];
        $params = [];

        if ($desde) {
            $where[] = "DATE(v.fecha) >= :desde";
            $params[':desde'] = $desde;
        }
        if ($hasta) {
            $where[] = "DATE(v.fecha) <= :hasta";
            $params[':hasta'] = $hasta;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " GROUP BY v.id, v.total, v.fecha, v.estado ORDER BY v.fecha DESC, v.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Eto para las charts we
    public function getVentasPorDia() {
    $pdo = getConexion();

    $sql = "
        SELECT DATE(v.fecha) AS dia, COALESCE(SUM(v.total), 0) AS total
        FROM ventas v
        WHERE v.fecha >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
          AND v.estado != 'anulada'
        GROUP BY DATE(v.fecha)
        ORDER BY dia ASC
    ";

    $filas = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    $porDia = [];
    foreach ($filas as $f) {
        $porDia[$f['dia']] = (float)$f['total'];
    }

    $labels = [];
    $data = [];

    for ($i = 6; $i >= 0; $i--) {
        $fecha = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('d/m', strtotime($fecha));
        $data[] = $porDia[$fecha] ?? 0;
    }

    return ['labels' => $labels, 'data' => $data];
}
}
?>