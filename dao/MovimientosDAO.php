<?php
require_once __DIR__ . '/../config/database.php';

class MovimientosDAO {

    public function registrar($productoId, $tipo, $cantidad, $stockAnterior, $stockNuevo, $usuarioId = null, $motivo = null, $pdo = null) {
        if (!$pdo) {
            $pdo = getConexion();
        }

        $stmt = $pdo->prepare(
            "INSERT INTO movimientos_stock
                (producto_id, tipo, cantidad, stock_anterior, stock_nuevo, usuario_id, motivo)
             VALUES (:producto_id, :tipo, :cantidad, :stock_anterior, :stock_nuevo, :usuario_id, :motivo)"
        );

        return $stmt->execute([
            ':producto_id'    => (int)$productoId,
            ':tipo'           => $tipo,
            ':cantidad'       => (int)$cantidad,
            ':stock_anterior' => (int)$stockAnterior,
            ':stock_nuevo'    => (int)$stockNuevo,
            ':usuario_id'     => $usuarioId !== null ? (int)$usuarioId : null,
            ':motivo'         => $motivo,
        ]);
    }

    public function getRango($desde = null, $hasta = null) {
        $pdo = getConexion();

        $sql = "
            SELECT
                m.id,
                m.producto_id,
                p.nombre AS producto,
                m.tipo,
                m.cantidad,
                m.stock_anterior,
                m.stock_nuevo,
                u.nombre AS usuario,
                m.motivo,
                m.created_at AS fecha
            FROM movimientos_stock m
            LEFT JOIN productos p ON p.id = m.producto_id
            LEFT JOIN usuarios  u ON u.id = m.usuario_id
        ";

        $where = [];
        $params = [];

        if ($desde) {
            $where[] = "DATE(m.created_at) >= :desde";
            $params[':desde'] = $desde;
        }
        if ($hasta) {
            $where[] = "DATE(m.created_at) <= :hasta";
            $params[':hasta'] = $hasta;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY m.created_at DESC, m.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPorProducto($productoId) {
        $pdo = getConexion();
        $stmt = $pdo->prepare("
            SELECT m.*, u.nombre AS usuario
            FROM movimientos_stock m
            LEFT JOIN usuarios u ON u.id = m.usuario_id
            WHERE m.producto_id = :pid
            ORDER BY m.created_at DESC, m.id DESC
        ");
        $stmt->execute([':pid' => (int)$productoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}