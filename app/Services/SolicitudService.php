<?php

namespace App\Services;

use App\Database;
use PDO;

class SolicitudService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    public function solicitarLibro($idLibro)
    {
        $stmt = $this->db->prepare("SELECT disponible FROM libros WHERE id = ?");
        $stmt->execute([$idLibro]);
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($libro && $libro['disponible']) {
            $stmt = $this->db->prepare("INSERT INTO solicitudes (libro_id, fecha) VALUES (?, NOW())");
            $stmt->execute([$idLibro]);

            $stmt = $this->db->prepare("UPDATE libros SET disponible = 0 WHERE id = ?");
            $stmt->execute([$idLibro]);

            return "Solicitud realizada con éxito.";
        } else {
            return "El libro no está disponible.";
        }
    }
    public function listarSolicitudes()
{
    $sql = "SELECT s.id, l.titulo, l.autor, s.fecha, l.disponible
            FROM solicitudes s
            JOIN libros l ON s.libro_id = l.id
            ORDER BY s.fecha DESC";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
