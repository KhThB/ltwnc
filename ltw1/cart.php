<?php
session_start();

// Kiểm tra nếu giỏ hàng không tồn tại trong session, tạo mới
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu có yêu cầu xóa sản phẩm
if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    unset($_SESSION['cart'][$productId]); // Xóa sản phẩm khỏi giỏ hàng
    header('Location: cart.php'); // Quay lại trang giỏ hàng
    exit;
}

// Cập nhật số lượng sản phẩm khi người dùng thay đổi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $productId => $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }
}

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
include 'db_connect.php'; // Kết nối cơ sở dữ liệu

// Lấy thông tin các sản phẩm trong giỏ hàng
$cartProducts = [];
foreach ($_SESSION['cart'] as $productId => $cartItem) {
    $query = "SELECT * FROM products WHERE productId = :productId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([':productId' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        $product['quantity'] = $cartItem['quantity']; // Thêm số lượng vào thông tin sản phẩm
        $cartProducts[] = $product;
    }
}

// Tính tổng tiền của giỏ hàng
$totalPrice = 0;
foreach ($cartProducts as $product) {
    $totalPrice += $product['price'] * $product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>2Land</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/cart.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet"
          href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <!-- fevicon -->
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <!-- font css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
</head>
<body>

<!-- HEADER SECTION -->
<div class="header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index-login.html"><img src="images/doze-logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index-login.html">TRANG CHỦ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu-login.html">SẢN PHẨM</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="cart.php">
                            <i class="bx bx-cart" aria-hidden="true"></i> 
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- GIỎ HÀNG SECTION -->
<div class="cart_section">
    <div class="container">
        <h2 class="text-center">Giỏ Hàng</h2>
        <form action="cart.php" method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sản Phẩm</th>
                        <th scope="col">Tên Sản Phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số Lượng</th>
                        <th scope="col">Tổng</th>
                        <th scope="col">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartProducts as $product): ?>
                        <tr>
                            <td><img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>" class="cart-product-image"></td>
                            <td><?php echo $product['title']; ?></td>
                            <td class="price"><?php echo number_format($product['price'], 0, ',', '.') ?> VND</td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product['productId']; ?>]" value="<?php echo $product['quantity']; ?>" min="1" class="quantity-input">
                            </td>
                            <td class="total-price"><?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.') ?> VND</td>
                            <td><a href="cart.php?remove=<?php echo $product['productId']; ?>" class="btn btn-danger">Xóa</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <div class="row">
                    <div class="col-md-6">
                        <a href="menu-login.html" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <p><strong>Tổng Tiền: </strong><?php echo number_format($totalPrice, 0, ',', '.') ?> VND</p>
                        <a href="payment.php" class="btn btn-success">Thanh Toán</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- FOOTER SECTION -->
<div class="footer_section layout_padding">
    <div class="container">
       <div class="row">
          <div class="col-md-12">
             <h1 class="address_text">Địa Chỉ</h1>
             <p class="footer_text">Gia nhập đại gia đình 2Land ngay tại: </p>
             <p class="footer_text">343 Lạc Long Quân Phường 11 Quận 11 TP.HCM </p>
             <div class="location_text">
                <ul>
                   <li><i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left_10">+84 1234567890</span></li>
                   <li><i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left_10">2ldhihi@gmail.com</span></li>
                </ul>
             </div>
          </div>
       </div>
    </div>
</div>

<!-- COPYRIGHT SECTION -->
<div class="copyright_section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <p class="copyright_text">2020 All Rights Reserved. Design by <a href="https://html.design">Free Html Templates</a></p>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="footer_social_icon">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Javascript files-->
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/data.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/menu.js"></script>

</body>
</html>
