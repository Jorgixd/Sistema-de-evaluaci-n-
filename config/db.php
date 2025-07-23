<?php
class Database {
    // --- CONFIGURACIÓN DE CONEXIÓN ---
    private $host = 'dpg-d20edt7gi27c73ch5sbg-a';           // Host de tu base de datos Render
    private $db_name = 'cevaluacion';                       // Nombre de la base de datos
    private $username = 'root';                             // Usuario PostgreSQL
    private $password = '2mapSsNT7OsiBwBnXousZIZVsEvoYl3H'; // Contraseña PostgreSQL
    private $port = '5432';                                 // Puerto PostgreSQL
    // ----------------------------------

    private $conn;

    public function connect() {
        if ($this->conn) {
            return $this->conn;
        }

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Error de Conexión: ' . $e->getMessage());
        }

        return $this->conn;
    }
}
?>
