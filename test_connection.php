<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=loginsystem", "root", ""); // Change "testdb" to your actual database name
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "PDO connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
