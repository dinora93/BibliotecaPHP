<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Libro;
use App\Services\LibroService;

$titulo = readline("Título: ");
$autor = readline("Autor: ");
$categoria_id = readline("ID de categoría: ");


$libro = new Libro($titulo, $autor, $categoria_id);
$servicio = new LibroService();

if ($servicio->crearLibro($libro)) {
    echo "Libro creado exitosamente.\n";
} else {
    echo "Error al crear el libro.\n";
}
