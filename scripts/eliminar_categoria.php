<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CategoriaService;

$servicio = new CategoriaService();

$id = readline("ID de la categoría a eliminar: ");

$confirmacion = readline("¿Estás seguro? Esto eliminará la categoría (s/n): ");
if (strtolower($confirmacion) === 's') {
    if ($servicio->eliminarCategoria($id)) {
        echo "Categoría eliminada.\n";
    } else {
        echo "Error al eliminar la categoría (puede que esté siendo usada).\n";
    }
} else {
    echo "Operación cancelada.\n";
}
