<?php

// بدء جلسة المستخدم
session_start();

// إنهاء جلسة المستخدم
session_destroy();

// إعادة توجيه المستخدم إلى صفحة login
header("Location: login.php");
exit();

?>
