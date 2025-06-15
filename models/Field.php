<?php
require_once 'config/database.php';

class Field {
    private $conn;
    private $table_name = "fields";

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAllFields() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableFields() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status = 'available' ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFieldById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createField($data) {
        $query = "INSERT INTO " . $this->table_name . " (name, type, description, price_per_hour, status) 
                 VALUES (:name, :type, :description, :price_per_hour, :status)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":type", $data['type']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":price_per_hour", $data['price_per_hour']);
        $stmt->bindParam(":status", $data['status']);
        
        return $stmt->execute();
    }

    public function updateField($id, $data) {
        $query = "UPDATE " . $this->table_name . " 
                 SET name = :name, 
                     type = :type,
                     description = :description, 
                     price_per_hour = :price_per_hour, 
                     status = :status 
                 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":type", $data['type']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":price_per_hour", $data['price_per_hour']);
        $stmt->bindParam(":status", $data['status']);
        
        return $stmt->execute();
    }

    public function deleteField($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?> 