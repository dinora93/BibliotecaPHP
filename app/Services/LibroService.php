<?php

namespace App\Services;

use App\Database;
use App\Models\Libro;
use PDO;

class LibroService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    public function crearLibro(Libro $libro)
    {
        $sql = "INSERT INTO libros (titulo, autor, categoria_id, disponible) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $libro->titulo,
            $libro->autor,
            $libro->categoria_id,
            $libro->disponible ? 1 : 0
        ]);
    }

    public function listarLibros()
    {
        $stmt = $this->db->query("SELECT l.*, c.nombre AS categoria  FROM libros l JOIN categorias c ON l.categoria_id = c.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarLibros($campo, $valor)
    {
        $sql = "SELECT l.*, c.nombre AS categoria FROM libros l JOIN categorias c ON l.categoria_id = c.id WHERE $campo LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%$valor%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarNoDisponible($id)
    {
        $stmt = $this->db->prepare("UPDATE libros SET disponible = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function marcarDisponible($id)
   {
    $stmt = $this->db->prepare("UPDATE libros SET disponible = 1 WHERE id = ?");
    return $stmt->execute([$id]);
   }
public function actualizarLibro($id, $titulo, $autor, $categoria_id)
{
    $sql = "UPDATE libros SET titulo = ?, autor = ?, categoria_id = ? WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$titulo, $autor, $categoria_id, $id]);
}

public function eliminarLibro($id)
{
    $sql = "DELETE FROM libros WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$id]);
}

}
