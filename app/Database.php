<?php

namespace App;

use PDO;
use Dotenv\Dotenv;

class Database
{
    private static $conexion;

    public static function conectar(): PDO
    {
        if (!self::$conexion) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../config');
            $dotenv->load();

            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

            try {
                self::$conexion = new PDO($dsn, $user, $pass);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        return self::$conexion;
    }
}
