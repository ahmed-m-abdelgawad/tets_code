
<?php

// إنشاء متغيرات للاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clients";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من حالة الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب اسم المستخدم وكلمة المرور من المتغيرات العامة
$user_name = $_POST["user_name"];
$password = $_POST["password"];

// إنشاء استعلام للتحقق من اسم المستخدم وكلمة المرور وجلب حقول branch_code و sector_code و role من جدول users
$sql = "SELECT * FROM users WHERE user_name = '$user_name' AND password = '$password'";

// تنفيذ الاستعلام وجلب النتيجة
$result = $conn->query($sql);

// إذا كانت هناك نتيجة مطابقة
if ($result->num_rows > 0) {

    // جلب صف واحد من النتيجة ككائن مصفوفة
    $row = $result->fetch_assoc();

    // بدء جلسة المستخدم
    session_start();

    // تخزين بيانات المستخدم في متغيرات جلسة
    $_SESSION["user_id"] = $row["user_id"];
    $_SESSION["user_name"] = $row["user_name"];
    $_SESSION["branch_code"] = $row["branch_code"];
    $_SESSION["sector_code"] = $row["sector_code"];
    $_SESSION["role"] = $row["role"];

    // إعادة توجيه المستخدم إلى صفحة index
    header("Location: index.html");
    exit();

} else {

    // إعادة توجيه المستخدم إلى صفحة login مع رسالة خطأ
    header("Location: login.html?error=اسم المستخدم أو كلمة المرور غير صحيحة");
    exit();
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();

?>
