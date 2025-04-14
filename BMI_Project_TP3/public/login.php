<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$loginError = '';
$registerError = '';
$registerSuccess = '';

// تسجيل دخول
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $loginError = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
    }
}

// تسجيل حساب جديد
if (isset($_POST['register'])) {
    $username = trim($_POST['new_username']);
    $password = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $registerError = 'كلمتا المرور غير متطابقتين.';
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetch()) {
            $registerError = 'اسم المستخدم مستخدم بالفعل.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
            $insert->bindParam(':username', $username);
            $insert->bindParam(':password', $hashed);
            if ($insert->execute()) {
                $registerSuccess = 'تم إنشاء الحساب بنجاح! يمكنك تسجيل الدخول الآن.';
            } else {
                $registerError = 'حدث خطأ أثناء إنشاء الحساب.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الدخول / التسجيل</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center" style="height:100vh;">

<div class="card shadow p-4">
    <ul class="nav nav-tabs mb-3" id="tabControl" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">تسجيل الدخول</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">تسجيل جديد</button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- تسجيل الدخول -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
            <?php if ($loginError): ?>
                <div class="alert alert-danger"><?php echo $loginError; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="اسم المستخدم" required>
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="كلمة المرور" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">دخول</button>
            </form>
        </div>

        <!-- التسجيل -->
        <div class="tab-pane fade" id="register" role="tabpanel">
            <?php if ($registerError): ?>
                <div class="alert alert-danger"><?php echo $registerError; ?></div>
            <?php elseif ($registerSuccess): ?>
                <div class="alert alert-success"><?php echo $registerSuccess; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group mb-3">
                    <input type="text" name="new_username" class="form-control" placeholder="اسم المستخدم الجديد" required>
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="new_password" class="form-control" placeholder="كلمة المرور" required>
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="confirm_password" class="form-control" placeholder="تأكيد كلمة المرور" required>
                </div>
                <button type="submit" name="register" class="btn btn-success w-100">تسجيل</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
