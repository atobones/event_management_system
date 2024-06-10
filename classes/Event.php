<?php
require_once 'Database.php';

class Event {
    private $conn;
    private $table = 'events';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($user_id, $event_name, $description, $event_date, $location) {
        $query = "INSERT INTO " . $this->table . " (user_id, event_name, description, event_date, location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$user_id, $event_name, $description, $event_date, $location])) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $event_name, $description, $event_date, $location) {
        $query = "UPDATE " . $this->table . " SET event_name = ?, description = ?, event_date = ?, location = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$event_name, $description, $event_date, $location, $id])) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$id])) {
            return true;
        }
        return false;
    }

    public function getUserEvents($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
