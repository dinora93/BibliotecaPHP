<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Categoria;
use App\Services\CategoriaService;

$nombre = readline("Nombre de la nueva categoría: ");

$categoria = new Categoria($nombre);
$servicio = new CategoriaService();

if ($servicio->crearCategoria($categoria)) {
    echo "Categoría creada exitosamente.\n";
} else {
    echo "Error al crear la categoría.\n";
}
