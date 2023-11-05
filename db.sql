-- إنشاء قاعدة بيانات باسم clients
CREATE DATABASE clients;

-- استخدام قاعدة بيانات clients
USE clients;


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





أهلا بك، هذا هو بينغ. يمكنني مساعدتك في إنشاء نموذج لتسجيل بيانات العملاء باستخدام PHP, MySQL, CSS, JS, HTML5. هذا هو الكود الذي أنشأته لك:

<code> <?php // الاتصال بقاعدة البيانات MySQL $servername = “localhost”; $username = “root”; $password = “”; $dbname = “customers”;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

// التحقق من تسجيل الدخول بالبريد الإلكتروني وكلمة المرور session_start();

if (!isset($_SESSION[‘email’]) || !isset($_SESSION[‘password’])) { header(“Location: login.php”); exit(); }

// جلب اسم المستخدم وتصنيف القطاع من جدول المستخدمين $user_name = $_SESSION[‘email’]; $user_sector = $_SESSION[‘sector’];

// إنشاء جدول العملاء إذا لم يكن موجودًا $sql = “CREATE TABLE IF NOT EXISTS customers ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, user_name VARCHAR(30) NOT NULL, customer_name VARCHAR(40) NOT NULL, address VARCHAR(100) NOT NULL, phone_number VARCHAR(11) NOT NULL, port_type VARCHAR(20) NOT NULL, visit_days VARCHAR(50) NOT NULL, customer_category VARCHAR(20) NOT NULL, route VARCHAR(10) NOT NULL )”;

if ($conn->query($sql) === FALSE) { echo "Error creating table: " . $conn->error; }

// إدخال بيانات العميل في جدول العملاء إذا تم الضغط على زر إرسال if (isset($_POST[‘submit’])) { $customer_name = $_POST[‘customer_name’]; $address = $_POST[‘address’]; $phone_number = $_POST[‘phone_number’]; $port_type = $_POST[‘port_type’]; $visit_days = implode(", ", $_POST[‘visit_days’]); $customer_category = $_POST[‘customer_category’]; $route = $_POST[‘route’];

$sql = “INSERT INTO customers (user_name, customer_name, address, phone_number, port_type, visit_days, customer_category, route) VALUES (‘$user_name’, ‘$customer_name’, ‘$address’, ‘$phone_number’, ‘$port_type’, ‘$visit_days’, ‘$customer_category’, ‘$route’)”;

if ($conn->query($sql) === TRUE) { echo “تم إدخال بيانات العميل بنجاح”; } else { echo "Error: " . $sql . “<br>” . $conn->error; } }

// جلب بيانات العملاء من جدول العملاء بناءً على تصنيف القطاع $sql = “SELECT * FROM customers WHERE customer_category = ‘$user_sector’”; $result = $conn->query($sql);

?>

<!DOCTYPE html> <html lang=“ar”> <head> <meta charset=“UTF-8”> <title>نموذج تسجيل بيانات العملاء</title> <style> /* تنسيق النموذج والجدول */ form { margin: 20px; padding: 20px; border: 1px solid black; }

table {
  margin: 20px;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  border: 1px solid black;
}

</style> <script> // دالة لإظهار حقل route بناءً على اختيار تصنيف العميل function showRoute() { var customer_category = document.getElementById(“customer_category”).value; var route = document.getElementById(“route”); var options = route.options; if (customer_category == “Restaurant”) { options.length = 0; options[0] = new Option(“HO0007”, “HO0007”); options[1] = new Option(“HO0008”, “HO0008”); options[2] = new Option(“HO0009”, “HO0009”); options[3] = new Option(“HO0010”, “HO0010”); options[4] = new Option(“HO0016”, “HO0016”); } else if (customer_category == “Hotel”) { options.length = 0; options[0] = new Option(“HO0005”, “HO0005”); options[1] = new Option(“HO0006”, “HO0006”); options[2] = new Option(“HO0013”, “HO0013”); } else if (customer_category == “Catering”) { options.length = 0; options[0] = new Option(“HO0001”, “HO0001”); options[1] = new Option(“HO0002”, “HO0002”); options[2] = new Option(“HO0003”, “HO0003”); options[3] = new Option(“HO0004”, “HO0004”); options[4] = new Option(“HO0011”, “HO0011”); options[5] = new Option(“HO0012”, “HO0012”); options[6] = new Option(“HO0014”, “HO0014”); } else { options.length = 0; } }

// دالة لتحديد جميع أيام الزيارات إذا تم اختيار كل أيام الأسبوع
function checkAllDays() {
  var all_days = document.getElementById("all_days");
  var visit_days = document.getElementsByName("visit_days[]");
  if (all_days.checked) {
    for (var i = 0; i < visit_days.length; i++) {
      visit_days[i].checked = true;
    }
  } else {
    for (var i = 0; i < visit_days.length; i++) {
      visit_days[i].checked = false;
    }
  }
}

</script> </head> <body> <h1>نموذج تسجيل بيانات العملاء</h1> <form method=“post” action=“<?php echo $_SERVER[‘PHP_SELF’]; ?>”> <p>اسم المستخدم: <?php echo $user_name; ?></p> <p>أسم العميل: <input type=“text” name=“customer_name” maxlength=“40” required></p> <p>العنوان: <input type=“text” name=“address” required></p> <p>رقم التليفون: <input type=“tel” name=“phone_number” pattern=“[0-9]{11}” required></p> <p>نوع المنفذ: <select name=“port_type” required> <option value=“”>اختر نوع المنفذ</option> <option value=“Ethernet”>Ethernet</option> <option value=“USB”>USB</option> <option value=“Wireless”>Wireless</option> </select></p> <p>ايام الزيارات: <input type=“checkbox” name=“visit_days[]” value=“السبت”> السبت <input type=“checkbox” name=“visit_days[]” value=“الاحد”> الاحد <input type=“checkbox” name=“visit_days[]” value=“الاثنين”> الاثنين <input type=“checkbox” name=“visit_days[]” value=“الثلاثاء”> الثلاثاء <input type=“checkbox” name=“visit_days[]” value=“الاربعاء”> الاربعاء <input type=“checkbox” name=“visit_days[]” value=“الخميس”> الخميس <input type=“checkbox” id=“all_days” value=“كل ايام الاسبوع” onclick=“checkAllDays()”> كل ايام الاسبوع </p> <p>تصنيف العميل: <select id=“customer_category” name=“customer_category” onchange=“showRoute()” required> <option value=“”>اختر تصنيف العميل</option> <option value=“Restaurant”>Restaurant</option> <option value=“Hotel”>Hotel</option> <option value=“Catering”>Catering</option> </select></p> <p>route: <select id=“route” name="route