<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\SolicitudService;
use App\Services\LibroService;

// Mostrar libros disponibles primero (opcional pero útil)
$libroService = new LibroService();
$libros = $libroService->listarLibros();

echo "=== Libros Disponibles ===\n";

foreach ($libros as $libro) {
    $estado = $libro['disponible'] ? 'Sí' : 'No';
    echo "{$libro['id']} - {$libro['titulo']} ({$libro['autor']}) - Disponible: {$estado}\n";
}

echo "\n";

$idLibro = readline("Ingrese el ID del libro que desea solicitar: ");

$solicitudService = new SolicitudService();
$mensaje = $solicitudService->solicitarLibro($idLibro);

echo $mensaje . "\n";
