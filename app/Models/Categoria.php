<?php

namespace App\Models;

class Categoria
{
    public $id;
    public $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }
}
