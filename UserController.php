<?php
class UserController {
    private $pdo; // Database connection

    // Constructor to initialize PDO
    public function __construct($pdo) {
        if (!$pdo) {
            die("Error: Database connection not established.");
        }
        $this->pdo = $pdo;
    }

    // Fetch all users
    public function getAllUsers() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching users: " . $e->getMessage());
        }
    }

    // Get a single user by ID
    public function getUserById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching user: " . $e->getMessage());
        }
    }

    // Create a new user
    // Create a new user (UPDATED)
public function createUser($name, $email, $role, $status, $password) {
    try {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, role, status, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $role, $status, $hashedPassword]);
    } catch (PDOException $e) {
        die("Error creating user: " . $e->getMessage());
    }
}


    // Update user details
    public function updateUser($id, $name, $email, $role, $status) {
        $sql = "UPDATE users SET name = :name, email = :email, Role = :Role, Status = :Status WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':Role' => $role,   // 🔹 Capital "R" matches the column name
            ':Status' => $status, // 🔹 Capital "S" matches the column name
            ':id' => $id
        ]);
    }
    
    
    // Delete a user
    public function deleteUser($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("Error deleting user: " . $e->getMessage());
        }
    }

    // Reset user password
    public function resetPassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            die("Error resetting password: " . $e->getMessage());
        }
    }
}
?>
