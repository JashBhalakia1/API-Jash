<?php
class Sales {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getInventory() {
        $stmt = $this->pdo->query("SELECT id, item_name, stock, price FROM inventory");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSale($item_id, $quantity) {
        try {
            // Get product details
            $stmt = $this->pdo->prepare("SELECT price, stock FROM inventory WHERE id = ?");
            $stmt->execute([$item_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product || $quantity > $product['stock']) {
                return false; // Stock unavailable
            }

            // Calculate total price
            $total_price = $product['price'] * $quantity;

            // Insert into sales table with default status 'Pending'
            $stmt = $this->pdo->prepare("INSERT INTO sales (item_id, quantity, total_price, status) VALUES (?, ?, ?, 'Pending')");
            $stmt->execute([$item_id, $quantity, $total_price]);

            // Reduce stock in inventory
            $stmt = $this->pdo->prepare("UPDATE inventory SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$quantity, $item_id]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getSales() {
        $stmt = $this->pdo->query("SELECT sales.id, inventory.item_name, sales.quantity, sales.total_price, sales.sale_date, sales.status 
                                   FROM sales 
                                   JOIN inventory ON sales.item_id = inventory.id 
                                   ORDER BY sales.sale_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSalesByDate($start_date, $end_date) {
        $sql = "SELECT s.id, i.item_name, s.quantity, (s.quantity * i.price) AS total_price, s.sale_date, s.status 
                FROM sales s
                JOIN inventory i ON s.item_id = i.id
                WHERE s.sale_date BETWEEN ? AND ? 
                ORDER BY s.sale_date DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAsShipped($sale_id) {
        $stmt = $this->pdo->prepare("UPDATE sales SET status = 'Shipped' WHERE id = ?");
        return $stmt->execute([$sale_id]);
    }
}
?>
