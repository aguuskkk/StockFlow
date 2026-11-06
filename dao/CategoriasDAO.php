<?php
require_once __DIR__ . '/../config/database.php';

class CategoriasDAO {

    // Solo seleccionamos lo que hay en la tabla categorias
    private const SELECT_BASE = "
        SELECT c.*
        FROM categorias c
    ";

    // Obtener todas las categorias 
    public function getAll() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " ORDER BY c.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Solo categorías de productos
    public function getProductos() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " WHERE c.tipo = 'producto' ORDER BY c.nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Solo categorías de gastos
    public function getGastos() {
        $pdo  = getConexion();
        $stmt = $pdo->query(self::SELECT_BASE . " WHERE c.tipo = 'gasto' ORDER BY c.nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>