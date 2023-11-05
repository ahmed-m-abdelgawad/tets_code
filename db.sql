-- إنشاء قاعدة بيانات باسم clients
CREATE DATABASE clients;

-- استخدام قاعدة بيانات clients
USE clients;

-- إنشاء جدول باسم clients لحفظ بيانات العملاء
CREATE TABLE clients (
    client_code VARCHAR(11) PRIMARY KEY, -- كود العميل
    sector_code VARCHAR(10), -- كود القطاع
    client_name VARCHAR(50), -- اسم العميل
    client_address VARCHAR(100), -- عنوان العميل
    sector_name VARCHAR(50), -- اسم القطاع
    branch_code VARCHAR(10) -- كود الفرع
);

-- إدخال بعض البيانات في جدول clients
INSERT INTO clients VALUES 
('12345678901', 'BK', 'أحمد محمد', 'القاهرة - مدينة نصر', 'مخبوزات الخصوص', '1030'),
('23456789012', 'TP', 'فاطمة علي', 'الإسكندرية - سيدي جابر', 'تتراباك شبرامنت', '1020'),
('34567890123', 'BK', 'يوسف خالد', 'الجيزة - الهرم', 'مخبوزات شبرامنت', '1020'),
('45678901234', 'TP', 'سارة أحمد', 'السويس - الأربعين', 'تتراباك الخصوص', '1030');

-- إنشاء جدول باسم notes لحفظ ملاحظات المستخدمين على العملاء
CREATE TABLE notes (
    note_id INT AUTO_INCREMENT PRIMARY KEY, -- رقم الملاحظة
    client_code VARCHAR(11), -- كود العميل
    user_id INT, -- رقم المستخدم
    user_name VARCHAR(50), -- اسم المستخدم
    branch_code VARCHAR(10), -- كود الفرع
    sector_name VARCHAR(50), -- اسم القطاع
    notes VARCHAR(200), -- الملاحظات
    coordinates VARCHAR(50), -- إحداثيات المستخدم
    time TIME, -- وقت إرسال الملاحظات
    date DATE, -- تاريخ إرسال الملاحظات
    FOREIGN KEY (client_code) REFERENCES clients(client_code) -- ربط كود العميل بجدول clients
);

-- إنشاء قاعدة بيانات باسم users
CREATE DATABASE users;

-- استخدام قاعدة بيانات users
USE users;

-- إنشاء جدول باسم users لحفظ بيانات المستخدمين وصلاحياتهم
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY, -- رقم المستخدم
    user_name VARCHAR(50), -- اسم المستخدم
    email VARCHAR(50), -- البريد الإلكتروني
    password VARCHAR(50), -- كلمة المرور
    branch_code VARCHAR(10), -- كود الفرع
    sector_name VARCHAR(50) -- اسم القطاع
);

-- إدخال بعض البيانات في جدول users
INSERT INTO users VALUES 
(NULL, 'زياد حسن', 'ziad@gmail.com', '1234', '1030', 'مخبوزات الخصوص'),
(NULL, 'رانيا مجدي', 'rana@yahoo.com', '1234', '1020', 'مخبوزات شبرامنت'),
(NULL, 'كريم عادل', 'karim@hotmail.com', '1234', '1030', 'تتراباك الخصوص'),
(NULL, 'هبة سامي', 'heba@outlook.com', '1234', '1020', 'تتراباك شبرامنت');
