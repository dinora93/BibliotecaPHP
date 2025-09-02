<?php

namespace App\Models;

class Libro
{
    public $id;
    public $titulo;
    public $autor;
    public $categoria_id;
    public $disponible;
    public $fecha_registro;

    public function __construct($titulo, $autor, $categoria_id, $disponible = true)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->categoria_id = $categoria_id;
        $this->disponible = $disponible;
      
    }
}
