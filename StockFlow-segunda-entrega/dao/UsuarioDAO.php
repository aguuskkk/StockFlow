<?php
require_once '../config/database.php';

class UsuarioDAO {

    public function getByEmail($email) {
        $pdo = getConexion();
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
    $pdo = getConexion();
    $stmt = $pdo->query(
        "SELECT * FROM usuarios"
    );
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insertar($nombre, $email, $password, $rol)
{
    $pdo = getConexion();

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO usuarios (nombre, email, password, rol)
         VALUES (:nombre, :email, :password, :rol)"
    );

    return $stmt->execute([
        ':nombre'   => $nombre,
        ':email'    => $email,
        ':password' => $passwordHash,
        ':rol'      => $rol
    ]);
}
}
?>