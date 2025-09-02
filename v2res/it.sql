-- Create the database
CREATE DATABASE IF NOT EXISTS reservations;
USE reservations;

-- Create tables table
CREATE TABLE IF NOT EXISTS tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_number VARCHAR(10) NOT NULL UNIQUE,
    capacity INT NOT NULL CHECK (capacity IN (2, 4, 6)),
    status ENUM('available', 'reserved', 'maintenance') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create reservations table
CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    party_size INT NOT NULL,
    special_requests TEXT,
    status ENUM('confirmed', 'cancelled', 'completed') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE SET NULL
);

-- Insert sample tables
INSERT INTO tables (table_number, capacity, status) VALUES
('T01', 2, 'available'),
('T02', 2, 'available'),
('T03', 2, 'available'),
('T04', 2, 'available'),
('T05', 4, 'available'),
('T06', 4, 'available'),
('T07', 4, 'available'),
('T08', 4, 'available'),
('T09', 6, 'available'),
('T10', 6, 'available'),
('T11', 6, 'maintenance'),
('T12', 2, 'available');

-- Insert sample reservations
INSERT INTO reservations (table_id, customer_name, customer_email, customer_phone, reservation_date, reservation_time, party_size, special_requests, status) VALUES
(1, 'John Smith', 'john.smith@example.com', '(555) 123-4567', CURDATE() + INTERVAL 1 DAY, '19:00:00', 2, 'Window seat preferred', 'confirmed'),
(5, 'Emily Johnson', 'emily@example.com', '(555) 987-6543', CURDATE() + INTERVAL 2 DAY, '18:30:00', 4, 'Celebrating anniversary', 'confirmed'),
(9, 'Michael Brown', 'michael.b@example.com', '(555) 456-7890', CURDATE() + INTERVAL 3 DAY, '20:00:00', 6, 'Need high chairs for children', 'confirmed'),
(3, 'Sarah Williams', 'sarah.w@example.com', '(555) 789-0123', CURDATE() - INTERVAL 1 DAY, '19:30:00', 2, NULL, 'completed'),
(7, 'Robert Davis', 'robert.d@example.com', '(555) 234-5678', CURDATE() + INTERVAL 5 DAY, '20:30:00', 4, 'Vegetarian options needed', 'confirmed');

-- Create a view to see available tables by capacity
CREATE VIEW available_tables AS
SELECT capacity, COUNT(*) as available_count
FROM tables
WHERE status = 'available'
GROUP BY capacity;

-- Create a view to see today's reservations
CREATE VIEW todays_reservations AS
SELECT r.*, t.table_number, t.capacity
FROM reservations r
JOIN tables t ON r.table_id = t.id
WHERE r.reservation_date = CURDATE()
AND r.status = 'confirmed';

-- Create a user for the application (change the password!)
CREATE USER 'reservation_admin'@'localhost' IDENTIFIED BY 'admin_password_123';

GRANT SELECT, INSERT, UPDATE, DELETE ON reservations.* 
TO 'reservation_admin'@'localhost';

FLUSH PRIVILEGES;