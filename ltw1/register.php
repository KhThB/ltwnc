<?php
// Kết nối cơ sở dữ liệu
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra sự tồn tại của dữ liệu form
    if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $query = "SELECT * FROM user WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $error_message = "Email đã tồn tại!";
        } else {
            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Chèn người dùng mới vào cơ sở dữ liệu
            $query = "INSERT INTO user (name, email, password, roleId) VALUES (:name, :email, :password, 2)"; // roleId = 2 cho User
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashed_password
            ]);

            $success_message = "Đăng ký thành công!";
            header("Location: login.php"); // Sau khi đăng ký thành công, chuyển đến trang đăng nhập
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <title>Đăng Ký</title>
</head>
<body>
    <div class="wrapper">
        <form action="register.php" method="POST"> <!-- Gửi dữ liệu đến chính trang này -->
            <h1>ĐĂNG KÍ</h1>

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php endif; ?>

            <!-- Tên tài khoản -->
            <div class="input-box">
                <input type="text" name="name" placeholder="Tên tài khoản" required>
                <i class='bx bx-user-circle'></i>
            </div>

            <!-- Mật khẩu -->
            <div class="input-box">
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <i class='bx bx-lock'></i>
            </div>

            <!-- Email -->
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bx-envelope'></i>
            </div>

            <button type="submit" class="btn">Đăng KÍ</button>

            <div class="register-link">
                <p>Bạn đã có tài khoản?</p> <a href="login.php">Đăng nhập ngay!</a>
            </div>
        </form>
    </div>
</body>
</html>
