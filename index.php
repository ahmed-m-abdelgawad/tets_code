

<html> <head> <script src=“https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js”></script> <script> // دالة لفتح نافذة جديدة تحتوي على form لإدخال بيانات العميل الجديد function addClient() { window.open(“add_client.html”, “_blank”); }

    // دالة لحذف العميل الحالي من قاعدة البيانات باستخدام كائن ajax
    function deleteClient() {
        // جلب قيمة كود العميل من حقل الإدخال
        var client_code = $("#client_code").val();

        // إنشاء كائن ajax
        var ajax = new XMLHttpRequest();

        // تحديد الطريقة والعنوان والتزامن للطلب
        ajax.open("GET", "delete_client.php?client_code=" + client_code, true);

        // تحديد الدالة التي ستتعامل مع الاستجابة
        ajax.onreadystatechange = function() {
            // إذا كانت الاستجابة جاهزة وناجحة
            if (this.readyState == 4 && this.status == 200) {
                // تحويل الاستجابة من نص json إلى كائن json
                var response = JSON.parse(this.responseText);

                // إذا كان هناك خطأ في الاستجابة
                if (response.error) {
                    // إظهار رسالة الخطأ
                    alert(response.error);
                } else {
                    // إظهار رسالة النجاح
                    alert(response.success);

                    // إعادة تحميل الصفحة
                    location.reload();
                }
            }
        };

        // إرسال الطلب
        ajax.send();
    }

    // دالة لجلب بيانات العميل من قاعدة البيانات باستخدام كائن ajax
    function getClient() {
        // جلب قيمة كود العميل من حقل الإدخال
        var client_code = $("#client_code").val();

        // إنشاء كائن ajax
        var ajax = new XMLHttpRequest();

        // تحديد الطريقة والعنوان والتزامن للطلب
        ajax.open("GET", "get_client.php?client_code=" + client_code, true);

        // تحديد الدالة التي ستتعامل مع الاستجابة
        ajax.onreadystatechange = function() {
            // إذا كانت الاستجابة جاهزة وناجحة
            if (this.readyState == 4 && this.status == 200) {
                // تحويل الاستجابة من نص json إلى كائن json
                var response = JSON.parse(this.responseText);

                // إذا كان هناك خطأ في الاستجابة
                if (response.error) {
                    // إظهار رسالة الخطأ
                    alert(response.error);
                } else {
                    // إظهار بيانات العميل في حقول form
                    $("#sector_code").val(response.sector_code);
                    $("#client_name").val(response.client_name);
                    $("#client_address").val(response.client_address);
                    $("#sector_name").val(response.sector_name);
                    $("#branch_code").val(response.branch_code);

                    // إذا كان العميل قد تم تعديله من قبل المستخدم
                    if (response.edited) {
                        // إظهار ملاحظات المستخدم في حقل النص
                        $("#notes").val(response.notes);
                    } else {
                        // إفراغ حقل النص
                        $("#notes").val("");
                    }
                }
            }
        };

        // إرسال الطلب
        ajax.send();
    }
</script>

</head> <body> <form> <label for=“client_code”>كود العميل:</label> <input type=“text” id=“client_code” name=“client_code”> <button type=“button” id=“submit” onclick=“getClient()”>إرسال</button> <?php // بدء جلسة session_start();

        // إذا كانت قيمة متغير جلسة role تساوي admin
        if ($_SESSION["role"] == "admin") {
            // إظهار زر إضافة عميل
            echo '<button type="button" id="add" onclick="addClient()">إضافة عميل</button>';

            // إظهار زر حذف عميل
            echo '<button type="button" id="delete" onclick="deleteClient()">حذف عميل</button>';
        }
    ?>
    <br>
    <label for="sector_code">كود القطاع:</label>
    <input type="text" id="sector_code" name="sector_code" readonly>
    <br>
    <label for="client_name">اسم العميل:</label>
    <input type="text" id="client_name" name="client_name" <?php
        // إذا كانت قيمة متغير جلسة role تساوي user
        if ($_SESSION["role"] == "user") {
            // جعل حقل الإدخال غير قابل للكتابة
            echo 'readonly';

            // إظهار رسالة تنبيه
            echo 'onfocus="alert(\'ليس لديك صلاحية التعديل على العميل\')"';
        }
    ?>>
    <br>
    <label for="client_address">عنوان العميل:</label>
    <input type="text" id="client_address" name="client_address" <?php
        // إذا كانت قيمة متغير جلسة role تساوي user
        if ($_SESSION["role"] == "user") {
            // جعل حقل الإدخال غير قابل للكتابة
            echo 'readonly';

            // إظهار رسالة تنبيه
            echo 'onfocus="alert(\'ليس لديك صلاحية التعديل على العميل\')"';
        }
    ?>>
    <br>
    <label for="sector_name">اسم القطاع:</label>
    <input type="text" id="sector_name" name="sector_name" readonly>
    <br>
    <label for="branch_code">كود الفرع:</label>
    <input type="text" id="branch_code" name="branch_code" readonly>
    <br>
    <label for="notes">ملاحظات:</label>
    <textarea id="notes" name="notes" rows="4" cols="50" <?php
        // إذا كانت قيمة متغير جلسة role تساوي user
        if ($_SESSION["role"] == "user") {
            // جعل حقل النص غير قابل للكتابة
            echo 'readonly';

            // إظهار رسالة تنبيه
            echo 'onfocus="alert(\'ليس لديك صلاحية التعديل على العميل\')"';
        }
    ?>></textarea>
</form>

</body> </html>