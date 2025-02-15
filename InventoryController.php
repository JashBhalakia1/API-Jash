<?php
class InventoryController {
    private $pdo;

    // Constructor to initialize PDO
    public function __construct($pdo) {
        if (!$pdo) {
            die("Error: Database connection not established.");
        }
        $this->pdo = $pdo;
    }

    // Fetch all products from inventory
    public function getAllProducts() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM inventory");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching products: " . $e->getMessage());
        }
    }

    // Add a new product to inventory
    public function addProduct($item_name, $stock, $price) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO inventory (item_name, stock, price) VALUES (?, ?, ?)");
            return $stmt->execute([$item_name, $stock, $price]);
        } catch (PDOException $e) {
            die("Error adding product: " . $e->getMessage());
        }
    }

    // Update an existing product in inventory
    public function updateProduct($id, $item_name, $stock, $price) {
        try {
            $stmt = $this->pdo->prepare("UPDATE inventory SET item_name = ?, stock = ?, price = ? WHERE id = ?");
            return $stmt->execute([$item_name, $stock, $price, $id]);
        } catch (PDOException $e) {
            die("Error updating product: " . $e->getMessage());
        }
    }

    // Delete a product from inventory
    public function deleteProduct($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM inventory WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("Error deleting product: " . $e->getMessage());
        }
    }

    // Fetch a product by ID
    public function getProductById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM inventory WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching product: " . $e->getMessage());
        }
    }
}
?>
