<?php
// config/database.php

$host = 'localhost';
$dbname = 'bmi_project'; // تأكد من وجود قاعدة البيانات أو قم بإنشائها مسبقاً
$username = 'root';
$password = '';

// إعدادات الاتصال باستخدام PDO
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // تفعيل وضع الاستثناءات للأخطاء
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}
?>
