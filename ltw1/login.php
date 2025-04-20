﻿<?php
session_start();
include 'db_connect.php';

// Kiểm tra nếu có tham số redirect_to trong URL
$redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : 'index.php'; // Nếu không có, chuyển về trang chủ

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra sự tồn tại của dữ liệu form
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Nhận dữ liệu từ form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Kiểm tra thông tin người dùng
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Đăng nhập thành công, lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['userId'];  // Lưu user_id vào session
            $_SESSION['user_name'] = $user['name'];  // Lưu user_name vào session
            header("Location: $redirect_to"); // Quay lại nơi người dùng nhấn vào nút
            exit;
        } else {
            $error_message = "Sai email hoặc mật khẩu.";  // Thông báo lỗi nếu đăng nhập thất bại
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Đăng nhập</title>
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h1>ĐĂNG NHẬP</h1>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            
            <!-- Email input -->
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bx-user-circle'></i>
            </div>

            <!-- Password input -->
            <div class="input-box">
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <i class='bx bx-lock'></i>
            </div>

            <!-- Remember me & Forgot password -->
            <div class="remember-forgor">
                <label> <input type="checkbox" name="remember">Ghi nhớ đăng nhập</label>
                <a href="#">Quên mật khẩu?</a>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn">Đăng nhập</button>

            <div class="register-link">
                <p>Bạn chưa có tài khoản?</p> <a href="register.php">Đăng kí ngay!</a>
            </div>
        </form>
    </div>
</body>
</html>
