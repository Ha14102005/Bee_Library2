<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>client/assets/css/stylecart.css">
    <?php include 'layout/header.php'; ?>
</head>

<body>
    <h1>Your Cart</h1>
    <div class="container">
        <?php if (!empty($cart_items)):
            $total_price = 0;
        ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $key => $item):
                        $item_total = $item['quantity'] * $item['price'];
                        $total_price += $item_total;
                    ?>
                        <tr data-id="<?= $item['id'] ?>">
                            <td><?= $key + 1?></td>
                            <td><img src="<?= BASE_URL_ADMIN . $item['image']; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" width="50"></td>
                            <td><?= htmlspecialchars($item['title']); ?></td>
                            <td>
                                <div class="quantity-control">
                                    <button class="btn-decrease">-</button>
                                    <input type="number" class="quantity" value="<?= htmlspecialchars($item['quantity']); ?>" min="1" readonly>
                                    <button class="btn-increase">+</button>
                                </div>
                            </td>
                            <td class="price"><?= number_format($item['price'], 2); ?>VNĐ</td>
                            <td class="item-total"><?= number_format($item_total, 2); ?>VNĐ</td>
                            <td>
                                <a class="action-btn btn-remove" href="<?= BASE_URL ?>index.php?controller=Cart&action=remove&id=<?= $item['id']; ?>"
                                    onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    ❌
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <div class="cart-total">
        <h2>Total Price: <span id="total-price"><?= number_format($total_price, 2); ?></span> VNĐ</h2>
    </div>

    <div class="checkout">
        <a href="<?= BASE_URL ?>index.php?controller=Order&action=checkout" class="btn">Proceed to Checkout</a>
    </div>
<?php else: ?>
    <p>Giỏ hàng của bạn đang trống.<a href="<?= BASE_URL ?>index.php">Mua sắm ngay</a></p>
<?php endif; ?>
</div>
</body>

</html>

<?php require_once __DIR__ . '/../views/layout/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Xử lý tăng số lượng
    $('.btn-increase').click(function() {
        let row = $(this).closest('tr');
        let input = row.find('.quantity');
        let currentQty = parseInt(input.val());
        let newQty = currentQty + 1;
        updateQuantity(row, newQty);
    });

    // Xử lý giảm số lượng
    $('.btn-decrease').click(function() {
        let row = $(this).closest('tr');
        let input = row.find('.quantity');
        let currentQty = parseInt(input.val());
        if (currentQty > 1) { // Không cho giảm xuống dưới 1
            let newQty = currentQty - 1;
            updateQuantity(row, newQty);
        }
    });

    // Xử lý xóa sản phẩm
    $(".btn-remove").click(function (e) {
        e.preventDefault();
        var row = $(this).closest("tr");
        var id = row.data("id");

        $.ajax({
            url: "index.php?controller=Cart&action=remove",
            type: "GET",
            data: { id: id },
            success: function (response) {
                row.remove();
                updateTotalPrice();
            },
            error: function () {
                alert("Xóa sản phẩm thất bại!");
            }
        });
    });

    // Hàm cập nhật số lượng và giá
    function updateQuantity(row, newQty) {
        let id = row.data('id');
        let price = parseFloat(row.find('.price').text().replace('VNĐ', '').replace(/,/g, ''));
        
        $.ajax({
            url: "index.php?controller=Cart&action=update",
            type: "GET",
            data: { 
                id: id,
                quantity: newQty 
            },
            success: function(response) {
                row.find('.quantity').val(newQty);
                let newItemTotal = price * newQty;
                row.find('.item-total').text(numberFormat(newItemTotal) + 'VNĐ');
                updateTotalPrice();
            },
            error: function() {
                alert("Cập nhật số lượng thất bại!");
            }
        });
    }

    // Hàm cập nhật tổng giá
    function updateTotalPrice() {
        let total = 0;
        $('.item-total').each(function() {
            let itemTotal = parseFloat($(this).text().replace('VNĐ', '').replace(/,/g, ''));
            total += itemTotal;
        });
        $('#total-price').text(numberFormat(total));
    }

    // Hàm định dạng số
    function numberFormat(number) {
        return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }
});
</script>