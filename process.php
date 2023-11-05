<?php

// بدء جلسة المستخدم
session_start();

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

// التحقق من قيمة حقل edited
if ($_POST["edited"] == "1") {
    // تخزين رسالة خطأ في متغير جلسة وإعادة توجيه المستخدم إلى صفحة index مع رسالة خطأ
    $_SESSION["error"] = "تم التعديل المسبق على العميل.";
    header("Location: index.php");
    exit();
}

// إذا كانت قيمة حقل edited تساوي 0، استمر في إرسال الملاحظات
if (isset($_POST["client_code"]) && isset($_POST["notes"]) && isset($_POST["coordinates"])) {

    // جلب المعلومات من المتغيرات العامة
    $client_code = $_POST["client_code"];
    $notes = $_POST["notes"];
    $coordinates = $_POST["coordinates"];

    // جلب بيانات المستخدم من متغيرات جلسة
    $user_id = $_SESSION["user_id"];
    $user_name = $_SESSION["user_name"];
    $branch_code = $_SESSION["branch_code"];
    $sector_name = $_SESSION["sector_name"];

    // جلب الوقت والتاريخ الحاليين
    date_default_timezone_set("Africa/Cairo");
    $time = date("H:i:s");
    $date = date("Y-m-d");

    // إنشاء استعلام لإرسال المعلومات إلى قاعدة البيانات
    $sql = "INSERT INTO notes (client_code, user_id, user_name, branch_code, sector_name, notes, coordinates, time, date) VALUES ('$client_code', '$user_id', '$user_name', '$branch_code', '$sector_name', '$notes', '$coordinates', '$time', '$date')";

    // تنفيذ الاستعلام والتحقق من حالة الإرسال
    if ($conn->query($sql) === TRUE) {
        // تخزين رسالة نجاح في متغير جلسة
        $_SESSION["success"] = "تم إرسال الملاحظات بنجاح.";
    } else {
        // تخزين رسالة خطأ في متغير جلسة
        $_SESSION["error"] = "حدث خطأ أثناء إرسال الملاحظات: " . $conn->error;
    }
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();

// إعادة توجيه المستخدم إلى صفحة index مع رسالة نجاح أو خطأ
header("Location: index.php");
exit();

?>
