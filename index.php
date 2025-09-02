<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Libro;
use App\Models\Categoria;
use App\Services\LibroService;
use App\Services\CategoriaService;
use App\Services\SolicitudService;

$libroService = new LibroService();
$categoriaService = new CategoriaService();
$solicitudService = new SolicitudService();

function limpiarConsola()
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        system('cls');
    } else {
        system('clear');
    }
}

do {
    limpiarConsola();
    echo "===== MENÚ DE BIBLIOTECA =====\n";
    echo "1. Crear libro\n";
    echo "2. Editar libro\n";
    echo "3. Eliminar libro\n";
    echo "4. Listar libros\n";
    echo "5. Buscar libros\n";
    echo "6. Crear categoría\n";
    echo "7. Listar categorías\n";
    echo "8. Editar categoría\n";
    echo "9. Eliminar categoría\n";
    echo "10. Solicitar libro (prestar)\n";
    echo "11. Devolver libro\n";
    echo "12. Ver historial de préstamos\n";
    echo "0. Salir\n";
    echo "==============================\n";

    $opcion = readline("Seleccione una opción: ");
    echo "\n";

    switch ($opcion) {
        case 1:
            $titulo = readline("Título del libro: ");
            $autor = readline("Autor: ");
            $categoria_id = readline("ID de la categoría: ");
            $libro = new Libro($titulo, $autor, $categoria_id);
            $libroService->crearLibro($libro)
                ? print("✅ Libro creado.\n")
                : print("❌ Error al crear libro.\n");
            break;

            case 2:
                 $libros = $libroService->listarLibros();
    echo "=== Libros disponibles ===\n";
    foreach ($libros as $l) {
        echo "{$l['id']} - {$l['titulo']} ({$l['autor']}) - Categoría: {$l['categoria']}\n";
    }

    $id = readline("ID del libro a editar: ");
    $titulo = readline("Nuevo título: ");
    $autor = readline("Nuevo autor: ");
    $categoria_id = readline("Nuevo ID de categoría: ");

    $libroService->actualizarLibro($id, $titulo, $autor, $categoria_id)
        ? print("✅ Libro actualizado.\n")
        : print("❌ Error al actualizar el libro.\n");
                break;

            case 3:
                 $libros = $libroService->listarLibros();
    echo "=== Libros ===\n";
    foreach ($libros as $l) {
        echo "{$l['id']} - {$l['titulo']} ({$l['autor']})\n";
    }

    $id = readline("ID del libro a eliminar: ");
    $confirmar = readline("¿Está seguro de eliminar este libro? (s/n): ");
    if (strtolower($confirmar) === 's') {
        $libroService->eliminarLibro($id)
            ? print("✅ Libro eliminado.\n")
            : print("❌ Error al eliminar el libro.\n");
    } else {
        echo "Operación cancelada.\n";
    }
                break;

        case 4:
            $libros = $libroService->listarLibros();
            foreach ($libros as $l) {
                $estado = $l['disponible'] ? 'Sí' : 'No';
                echo "{$l['id']} - {$l['titulo']} ({$l['autor']}) - Categoría: {$l['categoria']} - Registro: {$l['fecha_registro']} - Disponible: {$estado}\n";
            }
            break;

        case 5:
            $campo = readline("Buscar por (titulo / autor / categoria): ");
            $valor = readline("Valor a buscar: ");
            $campo = ($campo === "categoria") ? "c.nombre" : "l." . $campo;

            $libros = $libroService->buscarLibros($campo, $valor);
            foreach ($libros as $l) {
                echo "{$l['id']} - {$l['titulo']} ({$l['autor']}) - Categoría: {$l['categoria']} - Registro: {$l['fecha_registro']} - Disponible: " . ($l['disponible'] ? 'Sí' : 'No') . "\n";
            }
            break;

        case 6:
            $nombre = readline("Nombre de la categoría: ");
            $categoria = new Categoria($nombre);
            $categoriaService->crearCategoria($categoria)
                ? print("✅ Categoría creada.\n")
                : print("❌ Error al crear categoría.\n");
            break;

        case 7:
            $categorias = $categoriaService->listarCategorias();
            foreach ($categorias as $c) {
                echo "{$c['id']} - {$c['nombre']}\n";
            }
            break;

        case 8:
            $id = readline("ID de la categoría a editar: ");
            $nuevoNombre = readline("Nuevo nombre: ");
            $categoriaService->actualizarCategoria($id, $nuevoNombre)
                ? print("✅ Categoría actualizada.\n")
                : print("❌ Error al actualizar.\n");
            break;

        case 9:
            $id = readline("ID de la categoría a eliminar: ");
            $confirmar = readline("¿Estás seguro? (s/n): ");
            if (strtolower($confirmar) === 's') {
                $categoriaService->eliminarCategoria($id)
                    ? print("✅ Categoría eliminada.\n")
                    : print("❌ Error al eliminar (posible uso en libros).\n");
            } else {
                echo "Operación cancelada.\n";
            }
            break;

        case 10:
            $libros = $libroService->listarLibros();
            echo "=== Libros disponibles ===\n";
            foreach ($libros as $l) {
                if ($l['disponible']) {
                    echo "{$l['id']} - {$l['titulo']} ({$l['autor']})\n";
                }
            }
            $id = readline("ID del libro a solicitar: ");
            echo $solicitudService->solicitarLibro($id) . "\n";
            break;

        case 11:
            $libros = $libroService->listarLibros();
            echo "=== Libros prestados ===\n";
            foreach ($libros as $l) {
                if (!$l['disponible']) {
                    echo "{$l['id']} - {$l['titulo']} ({$l['autor']})\n";
                }
            }
            $id = readline("ID del libro a devolver: ");
            $libroService->marcarDisponible($id)
                ? print("✅ Libro devuelto.\n")
                : print("❌ Error al devolver libro.\n");
            break;
case 12:
    $prestamos = $solicitudService->listarSolicitudes();
    if (empty($prestamos)) {
        echo "No hay préstamos registrados.\n";
    } else {
        echo "=== Historial de Préstamos ===\n";
        foreach ($prestamos as $p) {
            $estado = $p['disponible'] ? 'Disponible' : 'Prestado';
            echo "ID: {$p['id']} | Título: {$p['titulo']} | Autor: {$p['autor']} | Fecha: {$p['fecha']} | Estado: {$estado}\n";
        }
    }
    break;

        case 0:
            echo "¡Hasta luego!\n";
            exit;

        default:
            echo "⚠️ Opción no válida.\n";
            break;
    }

    readline("\nPresione ENTER para continuar...");
} while (true);
