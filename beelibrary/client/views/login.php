<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <link rel="stylesheet" href="../../client/assets/css/stylelogin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="login-container">
    <h2>Login Account</h2>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="error">
            <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>
    <form action="../../client/controllers/UserController.php?action=login" method="POST">
        <label for="email"> Địa chỉ email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <!-- Thêm CSRF token nếu cần -->
        <!-- <input type="hidden" name="csrf_token" value="<?php //echo generateCsrfToken(); ?>"> -->
        <button type="submit">Đăng nhập</button>
    </form>
    <div class="signup-link">
        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </div>
</div>
</body>
</html>