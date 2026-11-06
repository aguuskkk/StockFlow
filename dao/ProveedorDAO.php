<?php
require_once __DIR__ . '/../config/database.php';

class ProveedorDAO {

    // Solo seleccionamos lo que hay en la tabla proveedores
    private const SELECT_BASE = "
        SELECT p.*
        FROM proveedores p
    ";

    // Obtener todas las proveedores 
    public function getAll() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " ORDER BY p.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>