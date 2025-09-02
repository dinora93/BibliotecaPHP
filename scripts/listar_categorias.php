<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\CategoriaService;

$servicio = new CategoriaService();
$categorias = $servicio->listarCategorias();

if (empty($categorias)) {
    echo "No hay categorías registradas.\n";
} else {
    foreach ($categorias as $cat) {
        echo "{$cat['id']} - {$cat['nombre']}\n";
    }
}
