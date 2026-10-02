<?php

  class Producto {
    private $id;
    private $nombre;
    private $precio;
    private $stock;
    private $descripcion;

    public function __construct($id, $nombre, $precio, $stock, $descripcion){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock  = $stock;
        $this->descripcion = $descripcion;
    }
    public function getNombre() {return $this->nombre;}
    public function getPrecio() {return $this->precio;}
    public function getStock() {return $this->stock;}
    public function getId() {return $this->id;}
    public function getDescripcion() {return $this->id;}


  }