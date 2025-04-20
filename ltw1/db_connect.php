<?php
$host = 'localhost'; // Hoặc máy chủ của bạn
$dbname = 'doze_cafe';
$username = 'root'; // Username MySQL của bạn
$password = ''; // Mật khẩu MySQL của bạn

// Kết nối đến cơ sở dữ liệu
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Không thể kết nối đến cơ sở dữ liệu: " . $e->getMessage());
}
?>
