<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CategoriaService;

$servicio = new CategoriaService();

$id = readline("ID de la categoría a editar: ");
$nuevoNombre = readline("Nuevo nombre para la categoría: ");

if ($servicio->actualizarCategoria($id, $nuevoNombre)) {
    echo "Categoría actualizada con éxito.\n";
} else {
    echo "Error al actualizar la categoría.\n";
}
