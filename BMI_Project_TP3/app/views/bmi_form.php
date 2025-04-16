<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حاسبة مؤشر كتلة الجسم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .bmi-card {
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card bmi-card">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">حاسبة مؤشر كتلة الجسم (BMI)</h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">الوزن (كيلوجرام)</label>
                    <input type="number" step="0.1" name="weight" class="form-control" required min="30" max="300">
                </div>
                <div class="mb-3">
                    <label class="form-label">الطول (سنتيمتر)</label>
                    <input type="number" step="1" name="height" class="form-control" required min="100" max="250">
                </div>
                <button type="submit" class="btn btn-primary w-100">حساب</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>