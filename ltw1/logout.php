<?php
session_start();
session_unset(); // Hủy tất cả các biến session
session_destroy(); // Hủy session
header("Location: login.php"); // Chuyển hướng về trang login
exit;
?>
