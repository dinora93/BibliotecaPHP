<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\LibroService;

$servicio = new LibroService();
$libros = $servicio->listarLibros();

foreach ($libros as $libro) {
    echo "{$libro['id']} - {$libro['titulo']} ({$libro['autor']}) - Categoría: {$libro['categoria']}  - Fecha: {$libro['fecha_registro']} - Disponible: " . ($libro['disponible'] ? "Sí" : "No") . "\n";
}
