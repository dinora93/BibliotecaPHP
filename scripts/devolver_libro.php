<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\LibroService;

$libroService = new LibroService();
$libros = $libroService->listarLibros();

echo "=== Libros Prestados ===\n";

$hayPrestados = false;

foreach ($libros as $libro) {
    if (!$libro['disponible']) {
        echo "{$libro['id']} - {$libro['titulo']} ({$libro['autor']})\n";
        $hayPrestados = true;
    }
}

if (!$hayPrestados) {
    echo "No hay libros prestados actualmente.\n";
    exit;
}

echo "\n";

$idLibro = readline("Ingrese el ID del libro que desea devolver: ");

foreach ($libros as $libro) {
    if ($libro['id'] == $idLibro) {
        if (!$libro['disponible']) {
            if ($libroService->marcarDisponible($idLibro)) {
                echo "✅ Libro devuelto correctamente.\n";
            } else {
                echo "❌ Error al devolver el libro.\n";
            }
        } else {
            echo "⚠️ Ese libro ya está disponible.\n";
        }
        exit;
    }
}

echo "⚠️ No se encontró un libro con ese ID.\n";
