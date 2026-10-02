<?php
require_once '../config/database.php';

class ProductoDAO {

    public function getAll(){
        $pdo = getConexion();
        $stmt = $pdo->query('SELECT * FROM productos');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($nombre, $precio, $stock, $descripcion){
        try {
            $pdo = getConexion();
            $stmt = $pdo->prepare(
                'INSERT INTO productos (nombre, precio, stock, descripcion)
                VALUES (:nombre, :precio, :stock, :descripcion)'
            );
            $stmt->execute([
                ':nombre' => $nombre,
                ':precio' => $precio,
                ':stock'  => $stock,
                ':stock'  => $descripcion,

            ]);
            return true;
        } catch (PDOException $e) {
            error_log('Error al insertar producto: ' . $e->getMessage());
            return false; 
        }
        $stmt = $pdo->query("SELECT * FROM productos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    
}


?>