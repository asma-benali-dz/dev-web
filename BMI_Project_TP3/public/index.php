<?php
session_start();
require '../config/database.php';
require '../app/models/BmiModel.php';
require '../app/controllers/BmiController.php';

// إنشاء الكائنات
$model = new BmiModel($db);
$controller = new BmiController($model);

// معالجة الطلب
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // استخدام user_id = 1 للاختبار (في نظام حقيقي يستخدم ID المستخدم المسجل)
    $user_id = 1;
    $result = $controller->calculateBmi($user_id, $_POST['name'], $_POST['weight'], $_POST['height']);
    
    if ($result['success']) {
        $bmiResult = $result;
        $bmiHistory = $model->getBmiHistory($user_id);
        require '../app/views/bmi_result.php';
    } else {
        $error = $result['error'];
        require '../app/views/bmi_form.php';
    }
} else {
    require '../app/views/bmi_form.php';
}
?>