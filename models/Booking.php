<?php
require_once 'config/Database.php';

class Booking {
    private $conn;
    private $table_name = "bookings";

    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }

    public function getAllBookings() {
        $query = "SELECT b.*, f.name as field_name, u.username 
                 FROM " . $this->table_name . " b
                 LEFT JOIN fields f ON b.field_id = f.id
                 LEFT JOIN users u ON b.user_id = u.id
                 ORDER BY b.booking_date DESC, b.start_time ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getBookingsByUserId($user_id) {
        $query = "SELECT b.*, f.name as field_name, f.price_per_hour
                 FROM " . $this->table_name . " b
                 LEFT JOIN fields f ON b.field_id = f.id
                 WHERE b.user_id = :user_id
                 ORDER BY b.booking_date DESC, b.start_time ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

    public function getBookingById($id) {
        $query = "SELECT b.*, f.name as field_name, f.price_per_hour, u.username
                 FROM " . $this->table_name . " b
                 LEFT JOIN fields f ON b.field_id = f.id
                 LEFT JOIN users u ON b.user_id = u.id
                 WHERE b.id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isFieldAvailable($field_id, $booking_date, $start_time, $end_time) {
        $query = "SELECT COUNT(*) FROM " . $this->table_name . "
                 WHERE field_id = :field_id 
                 AND booking_date = :booking_date 
                 AND status != 'cancelled'
                 AND ((start_time <= :start_time AND end_time > :start_time)
                 OR (start_time < :end_time AND end_time >= :end_time)
                 OR (start_time >= :start_time AND end_time <= :end_time))";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':field_id', $field_id);
        $stmt->bindParam(':booking_date', $booking_date);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 0;
    }

    public function createBooking($data) {
        // Lấy thông tin sân để tính giá
        $query = "SELECT price_per_hour FROM fields WHERE id = :field_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':field_id', $data['field_id']);
        $stmt->execute();
        $field = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$field) {
            return false;
        }

        // Tạo đơn đặt sân
        $query = "INSERT INTO " . $this->table_name . " 
                 (field_id, user_id, booking_date, start_time, end_time, status, total_price) 
                 VALUES (:field_id, :user_id, :booking_date, :start_time, :end_time, :status, :total_price)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':field_id', $data['field_id']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':booking_date', $data['booking_date']);
        $stmt->bindParam(':start_time', $data['start_time']);
        $stmt->bindParam(':end_time', $data['end_time']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':total_price', $data['total_price']);
        
        return $stmt->execute();
    }

    public function updateBooking($id, $data) {
        $query = "UPDATE " . $this->table_name . " SET ";
        $params = [];
        
        // Xây dựng câu query động dựa trên dữ liệu được cung cấp
        if (isset($data['status'])) {
            $query .= "status = :status";
            $params[':status'] = $data['status'];
        }
        
        if (isset($data['booking_date'])) {
            if (count($params) > 0) $query .= ", ";
            $query .= "booking_date = :booking_date";
            $params[':booking_date'] = $data['booking_date'];
        }
        
        if (isset($data['start_time'])) {
            if (count($params) > 0) $query .= ", ";
            $query .= "start_time = :start_time";
            $params[':start_time'] = $data['start_time'];
        }
        
        if (isset($data['end_time'])) {
            if (count($params) > 0) $query .= ", ";
            $query .= "end_time = :end_time";
            $params[':end_time'] = $data['end_time'];
        }
        
        if (isset($data['total_price'])) {
            if (count($params) > 0) $query .= ", ";
            $query .= "total_price = :total_price";
            $params[':total_price'] = $data['total_price'];
        }
        
        $query .= " WHERE id = :id";
        $params[':id'] = $id;
        
        $stmt = $this->conn->prepare($query);
        
        // Bind tất cả các tham số
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        return $stmt->execute();
    }

    public function updateBookingStatus($id, $status) {
        return $this->updateBooking($id, ['status' => $status]);
    }

    public function deleteBooking($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?> 