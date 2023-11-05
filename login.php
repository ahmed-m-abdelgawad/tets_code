<?php

// بدء جلسة المستخدم
session_start();

// إنشاء متغيرات للاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من حالة الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// إذا تم إرسال بيانات المستخدم من form
if (isset($_POST["email"]) && isset($_POST["password"])) {

    // جلب بيانات المستخدم من المتغيرات العامة
    $email = $_POST["email"];
    $password = $_POST["password"];

    // إنشاء استعلام للبحث عن بيانات المستخدم بناء على البريد الإلكتروني وكلمة المرور
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    // تنفيذ الاستعلام وجلب النتيجة
    $result = $conn->query($sql);

    // إذا كانت هناك نتيجة مطابقة
    if ($result->num_rows > 0) {

        // جلب صف واحد من النتيجة ككائن مصفوفة
        $row = $result->fetch_assoc();

        // تخزين بيانات المستخدم في متغيرات جلسة
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user_name"] = $row["user_name"];
        $_SESSION["branch_code"] = $row["branch_code"];
        $_SESSION["sector_name"] = $row["sector_name"];

        // إعادة توجيه المستخدم إلى صفحة index
        header("Location: index.php");
        exit();

    } else {

        // تخزين رسالة خطأ في متغير جلسة
        $_SESSION["error"] = "البريد الإلكتروني أو كلمة المرور غير صحيحة";
    }
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* استخدام css لتصميم form */
        form {
            width: 400px;
            margin: 0 auto;
            border: 1px solid black;
            padding: 20px;
            direction: rtl;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 80%;
            padding: 5px;
        }

        button {
            width: 100px;
            margin-top: 20px;
        }

        .alert {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <!-- حقل لإدخال البريد الإلكتروني -->
        <label for="email">أدخل البريد الإلكتروني:</label>
        <input type="email" id="email" name="email" required>
        <!-- حقل لإدخال كلمة المرور -->
        <label for="password">أدخل كلمة المرور:</label>
        <input type="password" id="password" name="password" required>
        <!-- زر لإرسال بيانات المستخدم -->
        <button type="submit" id="submit">دخول</button>
        <!-- عرض رسالة خطأ إذا كانت موجودة -->
        <?php
        if (isset($_SESSION["error"])) {
            echo "<p class='alert'>" . $_SESSION["error"] . "</p>";
            unset($_SESSION["error"]);
        }
        ?>
    </form>
</body>
</html>
