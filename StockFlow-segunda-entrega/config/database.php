<?php

function getConexion(){
    $host       = 'localhost';
    $dbname     = 'tienda_tricode';
    $usuario    = 'root';
    $password   = '';


    try {
        $pdo = new PDO (
            'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8',
            $usuario,
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Érro de conexcion: ' . $e->getMessage());
    }

}
?>