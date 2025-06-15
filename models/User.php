<?php
require_once 'config/database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function getAllUsers() {
        try {
            $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getAllUsers: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getUserById: " . $e->getMessage());
            return false;
        }
    }

    public function getUserByUsername($username) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getUserByUsername: " . $e->getMessage());
            return false;
        }
    }

    public function getUserByEmail($email) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error in getUserByEmail: " . $e->getMessage());
            return false;
        }
    }

    public function createUser($data) {
        $query = "INSERT INTO " . $this->table_name . "
                (username, password, email, full_name, phone, role)
                VALUES
                (:username, :password, :email, :full_name, :phone, :role)";

        $stmt = $this->conn->prepare($query);

        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":role", $data['role']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateUser($id, $data) {
        $query = "UPDATE " . $this->table_name . "
                SET email = :email,
                    full_name = :full_name,
                    phone = :phone
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":full_name", $data['full_name']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updatePassword($id, $new_password) {
        $query = "UPDATE " . $this->table_name . "
                SET password = :password
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Hash password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Bind values
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function deleteUser($id) {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log("Error in deleteUser: " . $e->getMessage());
            return false;
        }
    }

    public function login($username, $password) {
        global $conn;
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }
}
?> 