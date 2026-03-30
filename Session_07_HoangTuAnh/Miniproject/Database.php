<?php
class Database {
    private $host = "localhost";
    private $dbname = "product_admin";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8",
                $this->username,
                $this->password
            );

            // Set PDO error mode to exception for easier debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>