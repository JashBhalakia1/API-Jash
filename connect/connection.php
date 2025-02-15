<?php
class Connection {
    private $host = "localhost"; // Change if necessary
    private $dbname = "loginsystem"; // Change to your actual database name
    private $username = "root"; // Change if using a different user
    private $password = ""; // Change if your MySQL has a password
    public $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    public function getConnection() {
        return $this->pdo;
    }
}
?>
