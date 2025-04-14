<?php
// public/index.php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// تضمين إعدادات قاعدة البيانات
require_once __DIR__ . '/../config/database.php';

// تضمين ملفات الموديل والكنترولر
require_once __DIR__ . '/../app/models/BmiModel.php';
require_once __DIR__ . '/../app/controllers/BmiController.php';

// إنشاء كائن الموديل والكنترولر
$model = new BmiModel($db);
$controller = new BmiController($model);

// تحديد معرف المستخدم للتجربة (في التطبيق الحقيقي يتم استخدام نظام تسجيل دخول)
$user_id = 1;

$result = [];
// معالجة الطلب عند استلام نموذج POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = isset($_POST['name']) ? trim($_POST['name']) : '';
    $weight = isset($_POST['weight']) ? floatval($_POST['weight']) : 0;
    $height = isset($_POST['height']) ? floatval($_POST['height']) : 0;
    
    // حساب مؤشر كتلة الجسم وحفظ السجل
    $result = $controller->calculateBmi($user_id, $name, $weight, $height);
    
    // استرجاع تاريخ الحسابات لتحديث العرض
    $history = $controller->getHistory($user_id);
}

// تضمين ملف العرض (النموذج مع النتيجة)
include __DIR__ . '/../app/views/bmi_form.php';
?>
