
-- إنشاء جدول clients
CREATE TABLE clients (
    client_code varchar(11) PRIMARY KEY,
    sector_code varchar(10),
    client_name varchar(50),
    client_address varchar(100),
    sector_name varchar(50),
    branch_code varchar(10)
);

-- إضافة بعض البيانات العشوائية لجدول clients
INSERT INTO clients VALUES
('12345678901', 'A1', 'Ahmed Ali', 'Cairo', 'Sector A', 'B1'),
('23456789012', 'A2', 'Mohamed Hassan', 'Alexandria', 'Sector A', 'B2'),
('34567890123', 'B1', 'Fatma Ahmed', 'Giza', 'Sector B', 'B1'),
('45678901234', 'B2', 'Sara Mohamed', 'Aswan', 'Sector B', 'B2'),
('56789012345', 'C1', 'Ali Kamal', 'Luxor', 'Sector C', 'B1'),
('67890123456', 'C2', 'Hassan Omar', 'Suez', 'Sector C', 'B2');

-- إنشاء جدول users
CREATE TABLE users (
    user_id int PRIMARY KEY,
    user_name varchar(50),
    password varchar(50),
    branch_code varchar(10),
    sector_code varchar(10),
    role varchar(10)
);

-- إضافة بعض البيانات العشوائية لجدول users
INSERT INTO users VALUES
(1, 'admin', 'admin', 'B1', 'A1', 'admin'),
(2, 'user1', 'user1', 'B1', 'A1', 'user'),
(3, 'user2', 'user2', 'B2', 'A2', 'user'),
(4, 'user3', 'user3', 'B1', 'B1', 'user'),
(5, 'user4', 'user4', 'B2', 'B2', 'user'),
(6, 'user5', 'user5', 'B1', 'C1', 'user'),
(7, 'user6', 'user6', 'B2', 'C2', 'user');

-- إنشاء جدول notes
CREATE TABLE notes (
    note_id int PRIMARY KEY AUTO_INCREMENT,
    client_code varchar(11),
    user_id int,
    user_name varchar(50),
    branch_code varchar(10),
    sector_code varchar(10),
    notes varchar(100),
    coordinates varchar(50),
    time varchar(10),
    date varchar(10),
    FOREIGN KEY (client_code) REFERENCES clients(client_code),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
