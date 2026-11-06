<?php
require_once __DIR__ . '/../config/database.php';

class GastosDAO {

    public function getAll() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            "SELECT g.*, c.nombre AS categoria
             FROM gastos g
             LEFT JOIN categorias c ON c.id = g.categoria_id
             WHERE g.activo = 1
             ORDER BY g.fecha DESC, g.id DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById($id) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = :id AND activo = 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function insertar($descripcion, $categoria_id, $monto, $fecha, $estado) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare(
            "INSERT INTO gastos (descripcion, categoria_id, monto, fecha, estado)
             VALUES (:descripcion, :categoria_id, :monto, :fecha, :estado)"
        );
        return $stmt->execute([
            ':descripcion'  => $descripcion,
            ':categoria_id' => $categoria_id,
            ':monto'        => $monto,
            ':fecha'        => $fecha,
            ':estado'       => $estado
        ]);
    }


    public function actualizar($id, $descripcion, $categoria_id, $monto, $fecha, $estado) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare(
            "UPDATE gastos SET
                descripcion  = :descripcion,
                categoria_id = :categoria_id,
                monto        = :monto,
                fecha        = :fecha,
                estado       = :estado
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id'           => $id,
            ':descripcion'  => $descripcion,
            ':categoria_id' => $categoria_id,
            ':monto'        => $monto,
            ':fecha'        => $fecha,
            ':estado'       => $estado
        ]);
    }


    public function eliminar($id) {
        $pdo  = getConexion();
        $stmt = $pdo->prepare("UPDATE gastos SET activo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getTotalMes() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            "SELECT COALESCE(SUM(monto), 0) FROM gastos
             WHERE activo = 1 AND estado <> 'cancelado'
               AND YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = MONTH(CURDATE())"
        );
        return (float) $stmt->fetchColumn();
    }

    public function getTotalPendiente() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            "SELECT COALESCE(SUM(monto), 0) FROM gastos
             WHERE activo = 1 AND estado = 'pendiente'"
        );
        return (float) $stmt->fetchColumn();
    }

    public function getPromedioMes() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            "SELECT COALESCE(AVG(monto), 0) FROM gastos
             WHERE activo = 1 AND estado <> 'cancelado'
               AND YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = MONTH(CURDATE())"
        );
        return (float) $stmt->fetchColumn();
    }

    public function getCategoriaTop() {
        $pdo  = getConexion();
        $stmt = $pdo->query(
            "SELECT c.nombre
             FROM gastos g
             INNER JOIN categorias c ON c.id = g.categoria_id
             WHERE g.activo = 1 AND g.estado <> 'cancelado'
               AND YEAR(g.fecha) = YEAR(CURDATE()) AND MONTH(g.fecha) = MONTH(CURDATE())
             GROUP BY c.id, c.nombre
             ORDER BY SUM(g.monto) DESC
             LIMIT 1"
        );
        $nombre = $stmt->fetchColumn();
        return $nombre === false ? null : $nombre;
    }

    // Gastos en rango de fechas para reportes
    public function getRango($desde = null, $hasta = null) {
        $pdo = getConexion();

        $sql = "
            SELECT g.*, c.nombre AS categoria
            FROM gastos g
            LEFT JOIN categorias c ON c.id = g.categoria_id
            WHERE g.activo = 1
        ";

        $params = [];
        if ($desde) {
            $sql .= " AND DATE(g.fecha) >= :desde";
            $params[':desde'] = $desde;
        }
        if ($hasta) {
            $sql .= " AND DATE(g.fecha) <= :hasta";
            $params[':hasta'] = $hasta;
        }

        $sql .= " ORDER BY g.fecha DESC, g.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>