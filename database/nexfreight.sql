-- NexFreight Database Schema

CREATE DATABASE IF NOT EXISTS nexfreight;
USE nexfreight;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Shipments table
CREATE TABLE shipments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_number VARCHAR(50) UNIQUE NOT NULL,
    sender_name VARCHAR(100),
    sender_address TEXT,
    receiver_name VARCHAR(100),
    receiver_address TEXT,
    status ENUM('pending', 'in_transit', 'delivered') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Deliveries table
CREATE TABLE deliveries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shipment_id INT,
    delivery_date DATE,
    notes TEXT,
    FOREIGN KEY (shipment_id) REFERENCES shipments(id)
);

-- Services table
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2)
);

-- Insert sample data
INSERT INTO users (username, password, email, role) VALUES 
('admin', '$2y$10$examplehashedpassword', 'admin@nexfreight.com', 'admin');

INSERT INTO services (name, description, price) VALUES 
('Standard Shipping', 'Reliable shipping service', 10.00),
('Express Shipping', 'Fast delivery option', 25.00);