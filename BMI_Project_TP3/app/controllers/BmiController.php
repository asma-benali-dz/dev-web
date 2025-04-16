<?php
class BmiController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function calculateBmi($user_id, $name, $weight, $height) {
        try {
            // التحقق من صحة المدخلات
            if (empty($name)) {
                throw new Exception("الاسم مطلوب");
            }
            
            if (!is_numeric($weight) || $weight <= 0) {
                throw new Exception("الوزن يجب أن يكون رقمًا موجبًا");
            }
            
            if (!is_numeric($height) || $height <= 0) {
                throw new Exception("الطول يجب أن يكون رقمًا موجبًا");
            }

            // تحويل الطول من سم إلى متر
            $height_in_meters = $height / 100;

            // حساب BMI
            $bmi = $weight / ($height_in_meters * $height_in_meters);
            $status = $this->getBmiStatus($bmi);

            // حفظ النتائج
            $this->model->saveBmiRecord($user_id, $name, $weight, $height, $bmi, $status);

            return [
                'success' => true,
                'name' => $name,
                'weight' => $weight,
                'height' => $height,
                'bmi' => round($bmi, 2),
                'status' => $status
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function getBmiStatus($bmi) {
        if ($bmi < 18.5) return ' Underweight';
        elseif ($bmi < 25) return 'Normal weight';
        elseif ($bmi < 30) return ' Overweight';
        else return ' Obesity';
    }
}
?>