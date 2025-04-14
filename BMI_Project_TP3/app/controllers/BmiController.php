<?php
// app/controllers/BmiController.php

class BmiController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    // دالة لحساب مؤشر كتلة الجسم وحفظ النتائج
    public function calculateBmi($user_id, $name, $weight, $height) {
        // التحقق من صحة المدخلات
        if (empty($name) || empty($weight) || empty($height) || !is_numeric($weight) || !is_numeric($height) || $height <= 0) {
            return ['error' => 'الرجاء التأكد من إدخال البيانات بشكل صحيح.'];
        }

        // حساب مؤشر كتلة الجسم (BMI)
        $bmi = $weight / (($height / 100) ** 2); // تحويل الطول من سم إلى متر

        // التفسير حسب BMI
        if ($bmi < 18.5) {
            $interpretation = "Underweight";
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            $interpretation = "Normal weight";
        } elseif ($bmi >= 25 && $bmi < 30) {
            $interpretation = "Overweight";
        } else {
            $interpretation = "Obesity";
        }

        // حفظ السجل في قاعدة البيانات
        $saved = $this->model->saveBmiRecord($user_id, $name, $weight, $height, $bmi, $interpretation);

        // إرجاع البيانات للعرض
        return [
            'name'           => $name,
            'weight'         => $weight,
            'height'         => $height,
            'bmi'            => round($bmi, 2),
            'interpretation' => $interpretation,
            'saved'          => $saved
        ];
    }

    // دالة لاسترجاع تاريخ الحسابات للمستخدم
    public function getHistory($user_id) {
        return $this->model->getBmiHistory($user_id);
    }
}
?>
