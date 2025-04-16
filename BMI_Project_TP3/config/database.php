<?php
$host = 'localhost';
$dbname = 'bmi_project';
$username = 'root';
$password = '';

// إنشاء اتصال باستخدام MySQLi
$db = new mysqli($host, $username, $password, $dbname);

// التحقق من الاتصال
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// تعيين مجموعة المحارف
$db->set_charset("utf8");
?>