<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>client/assets/css/styleorder.css">
    <?php include 'layout/header.php'; ?>
</head>
<body>

<?php
// Đảm bảo các biến $order và $order_items đã được truyền từ controller
if (!isset($order) || !$order) {
    die("Không tìm thấy đơn hàng!");
}

// Lấy danh sách trạng thái đơn hàng để hiển thị
$orderModel = new Order();
$statusList = $orderModel->getOrderStatusList();
$statusMap = array_column($statusList, 'status_name', 'status_id');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="order-container">
        <!-- Tiêu đề đơn hàng -->
        <div class="order-header">
            <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code']) ?></h2>
            <p>Ngày đặt hàng: <?= date('d/m/Y H:i:s', strtotime($order['order_date'])) ?></p>
            <p>Trạng thái: <?= htmlspecialchars($statusMap[$order['status_id']] ?? 'Không xác định') ?></p>
        </div>

        <!-- Thông tin người nhận -->
        <div class="order-info">
            <h3>Thông tin giao hàng</h3>
            <p><strong>Tên người nhận:</strong> <?= htmlspecialchars($order['recipient_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['recipient_email']) ?></p>
            <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['recipient_phone']) ?></p>
            <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['recipient_address']) ?></p>
            <p><strong>Phương thức thanh toán:</strong> 
                <?= $order['payment_method_id'] == 1 ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán trực tuyến' ?>
            </p>
        </div>

        <!-- Danh sách sản phẩm trong đơn hàng -->
        <div class="order-items">
            <h3>Sản phẩm trong đơn hàng</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tên sách</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['title']) ?></td>
                            <td><img src="<?= BASE_URL_ADMIN . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" width="50"></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= number_format($item['total_price'], 0, ',', '.') ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tổng tiền -->
        <div class="total-amount">
            Tổng tiền: <?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ
        </div>

        <!-- Nút quay lại -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= BASE_URL ?>index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại trang chủ
            </a>
        </div>
    </div>
</body>
</html>
<?php include 'layout/footer.php'; ?>
</body>
</html>
