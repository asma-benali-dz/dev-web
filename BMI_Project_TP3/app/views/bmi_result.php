<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجة مؤشر كتلة الجسم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .result-card {
            max-width: 800px;
            margin: 30px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .bmi-value {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .chart-container {
            width: 100%;
            margin: 30px auto;
            direction: ltr;
        }
        .status-box {
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card result-card">
        <div class="card-header bg-success text-white">
            <h3 class="text-center">نتيجة حساب BMI</h3>
        </div>
        <div class="card-body">
            <div class="text-center">
                <h4><?= htmlspecialchars($bmiResult['name']) ?></h4>
                <div class="bmi-value"><?= $bmiResult['bmi'] ?></div>
                <div class="status-box alert 
                    <?php 
                    if ($bmiResult['status'] == ' Underweight') echo 'alert-warning';
                    elseif ($bmiResult['status'] == 'Normal weight') echo 'alert-success';
                    elseif ($bmiResult['status'] == ' Overweight') echo 'alert-info';
                    else echo 'alert-danger';
                    ?>
                ">
                    <?= $bmiResult['status'] ?>
                </div>
            </div>
            
            <table class="table table-bordered">
                <tr>
                    <th>الوزن</th>
                    <td><?= $bmiResult['weight'] ?> كجم</td>
                </tr>
                <tr>
                    <th>الطول</th>
                    <td><?= $bmiResult['height'] ?> سم</td>
                </tr>
            </table>
            
            <h4 class="mt-5 text-center">تطور مؤشر كتلة الجسم</h4>
            <div class="chart-container">
                <canvas id="bmiChart"></canvas>
            </div>
            
            <a href="index.php" class="btn btn-primary w-100 mt-3">حساب جديد</a>
        </div>
    </div>
</div>

<script>
// بيانات الرسم البياني من قاعدة البيانات
const bmiHistory = <?= json_encode($bmiHistory) ?>;

// خطوط إرشادية للتقييم
const bmiReferenceLines = {
    underweight: 18.5,
    normal: 25,
    overweight: 30
};

// إعداد الرسم البياني
const ctx = document.getElementById('bmiChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: bmiHistory.map(item => item.date),
        datasets: [{
            label: 'تطور BMI',
            data: bmiHistory.map(item => item.bmi),
            borderColor: '#4bc0c0',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2,
            pointRadius: 4,
            pointBackgroundColor: '#4bc0c0',
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                rtl: false,
                align: 'start'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'BMI: ' + context.raw.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                min: Math.min(...bmiHistory.map(item => item.bmi)) - 2,
                max: Math.max(...bmiHistory.map(item => item.bmi)) + 2,
                ticks: {
                    stepSize: 2
                },
                grid: {
                    color: function(context) {
                        const value = context.tick.value;
                        if (value < bmiReferenceLines.underweight) return 'rgba(255, 206, 86, 0.5)';
                        if (value < bmiReferenceLines.normal) return 'rgba(75, 192, 192, 0.5)';
                        if (value < bmiReferenceLines.overweight) return 'rgba(255, 159, 64, 0.5)';
                        return 'rgba(255, 99, 132, 0.5)';
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
</body>
</html>