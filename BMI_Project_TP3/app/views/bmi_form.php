<?php

$result = []; // مصفوفة لتخزين النتيجة
if (isset($_POST['weight']) && isset($_POST['height']) && is_numeric($_POST['weight']) && is_numeric($_POST['height']) && $_POST['height'] > 0) {
    // استلام الوزن والطول
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    // حساب BMI
    $bmi = $weight / (($height / 100) * ($height / 100));
    
    // تحديد التفسير بناءً على BMI
    if ($bmi < 18.5) {
        $interpretation = 'Underweight';
    } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
        $interpretation = 'Normal weight';
    } elseif ($bmi >= 25 && $bmi <= 29.9) {
        $interpretation = 'Overweight';
    } else {
        $interpretation = 'Obesity';
    }

    // تخزين النتيجة في المصفوفة $result
    $result = [
        'weight' => $weight,
        'height' => $height,
        'bmi' => round($bmi, 2),
        'interpretation' => $interpretation
    ];
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>حاسبة مؤشر كتلة الجسم</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .card-header {
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            color: white;
        }
        .badge {
            font-size: 0.85rem;
        }
        h2, h3 {
            font-weight: bold;
        }
    </style>
</head>
<body dir="rtl">
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header text-center">
            <h2>حاسبة مؤشر كتلة الجسم (BMI)</h2>
        </div>
        <div class="card-body">

            <!-- عرض النتيجة -->
            <?php if (!empty($result)): ?>
                <div class="alert alert-success">
                    <p><strong>الوزن:</strong> <?php echo htmlspecialchars($result['weight']); ?> كجم</p>
                    <p><strong>الطول:</strong> <?php echo htmlspecialchars($result['height']); ?> سم</p>
                    <p><strong>BMI:</strong> <?php echo htmlspecialchars($result['bmi']); ?></p>
                    <p><strong>التفسير:</strong> 
                        <span class="badge 
                            <?php
                                switch ($result['interpretation']) {
                                    case 'Underweight':
                                        $badgeClass = 'bg-primary text-white';
                                        break;
                                    case 'Normal weight':
                                        $badgeClass = 'bg-success text-white';
                                        break;
                                    case 'Overweight':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'Obesity':
                                        $badgeClass = 'bg-danger text-white';
                                        break;
                                    default:
                                        $badgeClass = 'bg-secondary text-white';
                                }
                                echo $badgeClass;
                            ?>">
                            <?php echo htmlspecialchars($result['interpretation']); ?>
                        </span>
                    </p>
                </div>
            <?php endif; ?>

            <!-- النموذج -->
            <form action="" method="post" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="weight" class="form-label">الوزن (كجم)</label>
                        <input type="number" step="0.1" class="form-control" name="weight" id="weight" required>
                    </div>
                    <div class="col-md-4">
                        <label for="height" class="form-label">الطول (سم)</label>
                        <input type="number" step="0.1" class="form-control" name="height" id="height" required>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-primary px-4">احسب</button>
                </div>
            </form>

            <!-- عرض سجل الحسابات -->
            <?php if (isset($history) && !empty($history)): ?>
                <h3 class="mt-4">سجل الحسابات</h3>
                <table class="table table-hover table-bordered text-center align-middle shadow-sm bg-white rounded">
                    <thead class="table-dark">
                        <tr>
                            <th>التاريخ والوقت</th>
                            <th>الاسم</th>
                            <th>الوزن</th>
                            <th>الطول</th>
                            <th>BMI</th>
                            <th>التفسير</th>
                            <th>إجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history as $record): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($record['timestamp']); ?></td>
                                <td><?php echo htmlspecialchars($record['name']); ?></td>
                                <td><?php echo htmlspecialchars($record['weight']); ?></td>
                                <td><?php echo htmlspecialchars($record['height']); ?></td>
                                <td><strong><?php echo round($record['bmi'], 2); ?></strong></td>
                                <td>
                                    <?php if (isset($record['interpretation'])): ?>
                                        <span class="badge <?php echo getBadgeClass($record['interpretation']); ?>">
                                            <?php echo htmlspecialchars($record['interpretation']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">غير محدد</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- زر الحذف -->
                                    <form action="bmi_form.php" method="post" style="display: inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $record['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
