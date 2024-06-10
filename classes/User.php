<?php
require_once 'Database.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function register($username, $email, $password) {
        if ($this->isUsernameExists($username)) {
            throw new Exception("Username already exists");
        }

        if ($this->isEmailExists($email)) {
            throw new Exception("Email already exists");
        }

        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO " . $this->table . " (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$username, $email, $password_hashed])) {
            return true;
        }
        return false;
    }

    private function isUsernameExists($username) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    private function isEmailExists($email) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>


