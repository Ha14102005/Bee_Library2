<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user_name = $_SESSION['user_name'] ?? '';
if (isset($_SESSION['user_name']) && $_SESSION['user_name'] !== null) {
    $user_name = htmlspecialchars($_SESSION['user_name']);
} else {
    $user_name = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bee Library</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>client/assets/css/styleheader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <div class="notification-bar">
        <div class="container">
            <div class="notification-left">
                <p>Bee Library - Kho tàng sách của bạn</p>
            </div>
            <div class="notification-right">
                <a href="#" class="wishlist"><i class="fas fa-heart"></i> Wishlist</a>
                <div class="user-dropdown">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Nếu đã đăng nhập -->
                        <span class="user"><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['user_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                        <div class="dropdown-menu">
                            <a href="<?= BASE_URL ?>client/controllers/UserController.php?action=logout">Đăng xuất</a>
                        </div>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập -->
                        <span class="user"><i class="fas fa-user"></i>Tài khoản</span>
                        <div class="dropdown-menu">
                            <a href="<?= BASE_URL ?>client/views/login.php">Đăng nhập</a>
                            <a href="<?= BASE_URL ?>client/views/register.php">Đăng ký</a>
                        </div>
                    <?php endif; ?>
                </div>
                <p>Bạn cần hỗ trợ? Gọi ngay: <a href="tel:024.9999.9999" class="fas fa-headset">024.9999.9999</a></p>
            </div>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="main-header">
        <div class="container">
            <div class="header-left">
                <a href="<?= BASE_URL ?>index.php" class="logo"><img src="<?= BASE_URL ?>client/views/layout/logo.jpg" alt="Bee Library Logo"></a>
            </div>
            <nav class="nav-menu">
                <ul>
                    <li><a href="<?= BASE_URL ?>index.php" class="<?= (!isset($_GET['controller']) || $_GET['controller'] == 'Home') ? 'active' : '' ?>">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropbtn">Danh mục</a>
                        <div class="dropdown-content">
                            <!-- Truyện cổ tích -->
                            <div class="sub-dropdown">
                                <a href="#">Truyện cổ tích</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=1">Cổ tích Việt Nam</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=12">Cổ tích thế giới</a>
                                </div>
                            </div>

                            <!-- Văn học -->
                            <div class="sub-dropdown">
                                <a href="#">Văn học</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=2">Văn học Việt Nam</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=11">Văn học thế giới</a>
                                </div>
                            </div>

                            <!-- Lịch sử -->
                            <div class="sub-dropdown">
                                <a href="#">Lịch sử</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=8">Lịch sử Việt Nam</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=4">Lịch sử thế giới</a>
                                </div>
                            </div>

                            <!-- Truyện tranh -->
                            <div class="sub-dropdown">
                                <a href="#">Truyện tranh</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=3">Truyện tranh</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=14">Trọn bộ truyện tranh</a>
                                </div>
                            </div>

                            <!-- Tiểu thuyết -->
                            <div class="sub-dropdown">
                                <a href="#">Tiểu thuyết</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=5">Tiểu thuyết trinh thám</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=9">Tiểu thuyết giả tưởng</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=10">Tiểu thuyết kinh dị</a>
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=13">Trọn bộ sách tiểu thuyết</a>
                                </div>
                            </div>

                            <!-- Tự truyện -->
                            <div class="sub-dropdown">
                                <a href="#">Tự truyện</a>
                                <div class="sub-dropdown-content">
                                    <a href="<?= BASE_URL ?>index.php?controller=Category&action=list&category_id=6">Sách tự truyện</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="container">
                    <div class="search-bar">
                        <form action="<?= BASE_URL ?>index.php" method="GET">
                            <input type="hidden" name="controller" value="Home">
                            <input type="hidden" name="action" value="index">
                            <input type="text" name="search" placeholder="Tìm kiếm sách,tác giả..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <div class="cart-info">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <!-- Nếu đã đăng nhập -->
                            <a href="<?= BASE_URL ?>index.php?controller=Cart&action=viewCart">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        <?php else: ?>
                            <!-- Nếu chưa đăng nhập -->
                            <a href="#" onclick="alert('Bạn cần đăng nhập để xem giỏ hàng!'); return false;">
                                <i class="fas fa-shopping-cart"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="order-info">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Nếu đã đăng nhập -->
                        <a href="<?= BASE_URL ?>index.php?controller=Order&action=viewAllOrders">
                            <i class="fa fa-receipt"></i>
                        </a>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập -->
                        <a href="#" onclick="alert('Bạn cần đăng nhập để xem đơn hàng!'); return false;">
                            <i class="fa fa-receipt"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </nav>
        </div>
    </header>
</body>

</html>