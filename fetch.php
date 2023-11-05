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

// جلب قيمة كود العميل من المتغيرات العامة
$client_code = $_GET["client_code"];

// جلب رقم المستخدم من متغيرات جلسة
session_start();
$user_id = $_SESSION["user_id"];

// إنشاء استعلام للبحث عن بيانات العميل بناء على كود العميل
$sql = "SELECT * FROM clients WHERE client_code = '$client_code'";

// تنفيذ الاستعلام وجلب النتيجة
$result = $conn->query($sql);

// إذا كانت هناك نتيجة مطابقة
if ($result->num_rows > 0) {

    // جلب صف واحد من النتيجة ككائن مصفوفة
    $row = $result->fetch_assoc();

    // إنشاء كائن json لإرساله كاستجابة
    $response = array(
        "client_code" => $row["client_code"],
        "sector_code" => $row["sector_code"],
        "client_name" => $row["client_name"],
        "client_address" => $row["client_address"],
        "sector_name" => $row["sector_name"],
        "branch_code" => $row["branch_code"]
    );

    // إنشاء استعلام آخر للبحث عن ملاحظات المستخدم على العميل بناء على كود العميل ورقم المستخدم
    $sql2 = "SELECT * FROM notes WHERE client_code = '$client_code' AND user_id = '$user_id'";

    // تنفيذ الاستعلام وجلب النتيجة
    $result2 = $conn->query($sql2);

    // إذا كانت هناك نتيجة مطابقة
    if ($result2->num_rows > 0) {

        // جلب صف واحد من النتيجة ككائن مصفوفة
        $row2 = $result2->fetch_assoc();

        // أضف خانة edited إلى كائن الاستجابة واجعل قيمتها 1
        $response["edited"] = 1;

        // أضف خانة notes إلى كائن الاستجابة واجعل قيمتها قيمة حقل notes من جدول notes
        $response["notes"] = $row2["notes"];
    }

} else {

    // إنشاء كائن json لإرسال رسالة خطأ كاستجابة
    $response = array(
        "error" => "لا يوجد عميل بهذا الكود"
    );
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();

// تحويل كائن json إلى نص json
$response = json_encode($response);

// إرسال نص json كاستجابة
echo $response;

?>
