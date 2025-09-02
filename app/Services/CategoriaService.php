<?php

namespace App\Services;

use App\Database;
use App\Models\Categoria;
use PDO;

class CategoriaService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    public function crearCategoria(Categoria $categoria)
    {
        $sql = "INSERT INTO categorias (nombre) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$categoria->nombre]);
    }

    public function listarCategorias()
    {
        $stmt = $this->db->query("SELECT * FROM categorias");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarCategoria($id, $nuevoNombre)
    {
        $sql = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nuevoNombre, $id]);
    }

    public function eliminarCategoria($id)
    {
        $sql = "DELETE FROM categorias WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
