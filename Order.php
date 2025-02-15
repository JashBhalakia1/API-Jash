<?php

require_once 'connect/connection.php';
class Order {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getInventory() {
        $stmt = $this->conn->prepare("SELECT * FROM inventory");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function placeOrder($userId, $itemId, $quantity) {
        $stmt = $this->conn->prepare("SELECT * FROM inventory WHERE id = ?");
        $stmt->execute([$itemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item || $item['stock'] < $quantity) {
            return "Insufficient stock!";
        }

        $totalPrice = $item['price'] * $quantity;

        $insertOrder = $this->conn->prepare("INSERT INTO orders (user_id, item_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $insertOrder->execute([$userId, $itemId, $quantity, $totalPrice]);

        $updateStock = $this->conn->prepare("UPDATE inventory SET stock = stock - ? WHERE id = ?");
        $updateStock->execute([$quantity, $itemId]);

        return "Order placed successfully!";
    }
}
?>
