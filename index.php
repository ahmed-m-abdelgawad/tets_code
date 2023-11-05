<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <style>
        /* استخدام css لتصميم form */
        form {
            width: 600px;
            margin: 0 auto;
            border: 1px solid black;
            padding: 20px;
            direction: rtl;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input, select {
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
    <form action="process.php" method="post">
        <!-- حقل لإدخال كود العميل -->
        <label for="client_code">أدخل كود العميل (11 رقم):</label>
        <input type="text" id="client_code" name="client_code" maxlength="11" minlength="11" 
        title=" كود العميل يجب ان يكون 11 رقم ويبدأ بـ 11 "pattern="[0-9]{11}" required>
        <!-- حقل لعرض كود العميل -->
        <label for="client_code_display">كود العميل:</label>
        <input type="text" id="client_code_display" name="client_code_display" readonly>
        <!-- حقل لعرض كود القطاع -->
        <label for="sector_code">كود القطاع:</label>
        <input type="text" id="sector_code" name="sector_code" readonly>
        <!-- حقل لعرض اسم العميل -->
        <label for="client_name">اسم العميل:</label>
        <input type="text" id="client_name" name="client_name" readonly>
        <!-- حقل لعرض عنوان العميل -->
        <label for="client_address">عنوان العميل:</label>
        <input type="text" id="client_address" name="client_address" readonly>
        <!-- حقل لعرض اسم القطاع -->
        <label for="sector_name">اسم القطاع:</label>
        <input type="text" id="sector_name" name="sector_name" readonly>
        <!-- حقل لعرض كود الفرع -->
        <label for="branch_code">كود الفرع:</label>
        <input type="text" id="branch_code" name="branch_code" readonly>
        <!-- حقل لتسجيل إحداثيات المستخدم -->
        <label for="coordinates">إحداثيات المستخدم:</label>
        <input type="text" id="coordinates" name="coordinates">
        <!-- حقل لكتابة ملاحظات -->
        <label for="notes">ملاحظات:</label>
        <input type="text" id="notes" name="notes">
        <!-- حقل مخفي لحفظ حالة التعديل على العميل -->
        <input type="hidden" id="edited" name="edited" value="0">
        <!-- زر لإرسال المعلومات إلى قاعدة البيانات أو إجراء بحث جديد -->
        <button type="submit" id="submit">إرسال</button>
    </form>

    <!-- استخدام js لإجراء بعض الوظائف -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>

    // عند تغيير قيمة حقل كود العميل
    $("#client_code").change(function() {
        
        // جلب قيمة حقل كود العميل
        var client_code = $(this).val();

        // إذا كانت قيمة حقل كود العميل غير فارغة وتحتوي على 11 رقم
        if (client_code != "" && client_code.length == 11) {

            // إنشاء كائن ajax
            var ajax = new XMLHttpRequest();

            // تحديد نوع ومسار وطريقة الطلب
            ajax.open("GET", "fetch.php?client_code="+client_code, true);

            // تحديد ما يجب فعله عند استلام الاستجابة
            ajax.onreadystatechange = function() {

                // إذا كانت الاستجابة جاهزة وناجحة
                if (this.readyState == 4 && this.status == 200) {

                    // تحويل الاستجابة إلى كائن json
                    var response = JSON.parse(this.responseText);

                    // إذا كانت الاستجابة تحتوي على خطأ
                    if (response.error) {

                        // عرض رسالة خطأ في حقل كود العميل
                        $("#client_code_display").val(response.error);

                        // تفريغ باقي حقول form
                        $("#sector_code").val("");
                        $("#client_name").val("");
                        $("#client_address").val("");
                        $("#sector_name").val("");
                        $("#branch_code").val("");
                        $("#coordinates").val("");
                        $("#notes").val("");

                        // جعل حقل notes غير قابل للكتابة
                        $("#notes").prop("readonly", true);
                        // تغيير نص زر submit إلى "البحث من جديد"
                        $("#submit").text("البحث من جديد");
                        // تغيير action و method لform إلى "#" و "get" لإجراء refresh للصفحة عند الضغط على زر submit
                        $("form").attr("action", "#");
                        $("form").attr("method", "get");

                    } else {

                        // عرض بيانات العميل في حقول form
                        $("#client_code_display").val(response.client_code);
                        $("#sector_code").val(response.sector_code);
                        $("#client_name").val(response.client_name);
                        $("#client_address").val(response.client_address);
                        $("#sector_name").val(response.sector_name);
                        $("#branch_code").val(response.branch_code);

                        // تحقق من خانة edited في كائن الاستجابة
                        if (response.edited == 1) {
                            // غير قيمة حقل edited إلى 1
                            $("#edited").val(1);
                            // أظهر رسالة تنبيه بأنه تم التعديل المسبق على العميل
                            alert("تم التعديل المسبق على هذا العميل. لا يمكنك إرسال ملاحظات جديدة.");
                            // جلب قيمة حقل ملاحظات من كائن الاستجابة وعرضها في حقل notes
                            $("#notes").val(response.notes);
                            // جعل حقل notes غير قابل للكتابة
                            $("#notes").prop("readonly", true);
                            // تغيير نص زر submit إلى "البحث من جديد"
                            $("#submit").text("البحث من جديد");
                            // تغيير action و method لform إلى "#" و "get" لإجراء refresh للصفحة عند الضغط على زر submit
                            $("form").attr("action", "#");
                            $("form").attr("method", "get");
                        }
                    }
                }
            };

            // إرسال الطلب
            ajax.send();
        }
    });

    // عند طلب السماح بالgps
    navigator.geolocation.getCurrentPosition(function(position) {

        // جلب إحداثيات المستخدم
        var x = position.coords.latitude;
        var y = position.coords.longitude;

        // عرض إحداثيات المستخدم في حقل coordinates
        $("#coordinates").val(x + ", " + y);
    });
    </script>
</body>
</html>
