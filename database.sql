-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS sports_management;
USE sports_management;

-- Tạo bảng users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng fields
CREATE TABLE IF NOT EXISTS fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type TEXT NOT NULL,
    description TEXT,
    price_per_hour DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'maintenance', 'booked') NOT NULL DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    field_id INT NOT NULL,
    user_id INT NOT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (field_id) REFERENCES fields(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Thêm dữ liệu mẫu cho bảng users
INSERT INTO users (username, password, email, full_name, phone, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com', 'Admin User', '0123456789', 'admin'),
('user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user1@example.com', 'Normal User', '0987654321', 'user');

-- Thêm dữ liệu mẫu cho bảng fields
INSERT INTO fields (name, type, description, price_per_hour, status) VALUES
('Sân 1', 'Sân cỏ nhân tạo', 'Sân cỏ nhân tạo', 200000, 'available'),
('Sân 2', 'Sân cỏ tự nhiên', 'Sân cỏ tự nhiên', 300000, 'available'),
('Sân 3', 'Sân cỏ nhân tạo', 'Sân cỏ nhân tạo', 250000, 'available');

-- Thêm dữ liệu mẫu cho bookings
INSERT INTO bookings (field_id, user_id, booking_date, start_time, end_time, total_price, status) VALUES
(1, 2, '2024-03-20', '18:00:00', '19:00:00', 200000, 'confirmed'),
(2, 2, '2024-03-21', '19:00:00', '20:00:00', 300000, 'pending'); 