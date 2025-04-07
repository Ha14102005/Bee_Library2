<?php
if (!isset($orders)) {
    die("Không có dữ liệu đơn hàng!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>client/assets/css/styleall_order.css">
    <?php include 'layout/header.php'; ?>
</head>
<body>
    <div class="orders-container">
        <!-- Tiêu đề -->
        <div class="orders-header">
            <h2>Danh sách đơn hàng của bạn</h2>
        </div>

        <!-- Bảng danh sách đơn hàng -->
        <?php if (count($orders) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['order_code']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                            <td><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= htmlspecialchars($order['status_name']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>index.php?controller=Order&action=viewOrder&order_id=<?= $order['order_id'] ?>" class="btn-detail">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-orders">Bạn chưa có đơn hàng nào.</p>
        <?php endif; ?>

        <!-- Nút quay lại -->
        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= BASE_URL ?>index.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại trang chủ
            </a>
        </div>
    </div>
</body>
</html>
<?php require_once __DIR__ . '/../views/layout/footer.php'; ?>
