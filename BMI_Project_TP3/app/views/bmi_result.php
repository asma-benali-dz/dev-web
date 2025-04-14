<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نتيجة حساب مؤشر كتلة الجسم</title>
    <!-- تضمين Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body dir="rtl">
<div class="container mt-5">
    <h2>نتيجة الحساب</h2>
    <?php if(isset($result) && !isset($result['error'])): ?>
        <p>الاسم: <?php echo htmlspecialchars($result['name']); ?></p>
        <p>الوزن: <?php echo htmlspecialchars($result['weight']); ?> كجم</p>
        <p>الطول: <?php echo htmlspecialchars($result['height']); ?> سم</p>
        <p>مؤشر كتلة الجسم: <?php echo htmlspecialchars($result['bmi']); ?></p>
        <p>التصنيف: <?php echo htmlspecialchars($result['status']); ?></p>
    <?php else: ?>
        <div class="alert alert-danger">
            <?php echo isset($result['error']) ? $result['error'] : 'حدث خطأ'; ?>
        </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary mt-3">العودة للنموذج</a>
</div>
</body>
</html>
