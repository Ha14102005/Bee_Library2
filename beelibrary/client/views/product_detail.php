<?php
require_once __DIR__ . '/../views/layout/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>client/assets/css/styledetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="product-detail-page">
        <h1>Chi tiết sản phẩm</h1>
        <div class="container">
            <!-- Bố cục sản phẩm -->
            <div class="product-container">
                <!-- Hình ảnh sách -->
                <div class="product-image">
                    <img src="<?= BASE_URL_ADMIN . htmlspecialchars($book['image']); ?>"
                        alt="<?= htmlspecialchars($book['title']); ?>"
                        class="img-fluid">
                </div>

                <!-- Thông tin chi tiết -->
                <div class="product-info">
                    <h2><?= htmlspecialchars($book['title']); ?></h2>
                    <p><strong>Tác giả:</strong> <?= htmlspecialchars($book['author']); ?></p>
                    <p><strong>Giá:</strong> <?= number_format($book['price'], 2); ?> VND</p>
                    <p><strong>Số lượng trong kho:</strong> <?= $book['stock']; ?></p>
                    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($book['description'])); ?></p>
                    <p><strong>Ngày nhập sách:</strong> <?= $book['published_date']; ?></p>

                    <!-- Form thêm vào giỏ hàng -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Form cho "Thêm vào giỏ hàng" -->
                        <form action="<?= BASE_URL ?>index.php?controller=Cart&action=addToCart" method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?= $book['book_id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Thêm vào giỏ hàng</button>
                        </form>

                        <!-- Form cho "Mua ngay" -->
                        <form action="<?= BASE_URL ?>index.php?controller=Cart&action=buyNow" method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?= $book['book_id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" name="buy_now" class="btn btn-danger">Mua ngay</button>
                        </form>
                    <?php else: ?>
                        <p>Bạn cần <a href="<?= BASE_URL ?>client/views/login.php">đăng nhập</a> để thêm sản phẩm vào giỏ hàng.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Container riêng cho phần đánh giá -->
        <div class="container reviews-container">
            <!-- Phần đánh giá -->
            <div class="reviews-section">
                <h3>Đánh giá và bình luận</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="<?= BASE_URL ?>index.php?controller=Review&action=addReview" method="POST">
                        <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                        <div class="form-group">
                            <label for="rating">Đánh giá (số sao):</label>
                            <select name="rating" id="rating" required>
                                <option value="5">5 sao</option>
                                <option value="4">4 sao</option>
                                <option value="3">3 sao</option>
                                <option value="2">2 sao</option>
                                <option value="1">1 sao</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Bình luận:</label>
                            <textarea name="comment" id="comment" rows="4" placeholder="Nhập bình luận của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                <?php else: ?>
                    <p>Bạn cần <a href="<?= BASE_URL ?>client/views/login.php">đăng nhập</a> để bình luận.</p>
                <?php endif; ?>

                <div class="reviews-list">
                    <h4>Các bình luận:</h4>
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review">
                                <p><strong><?= htmlspecialchars($review['user_name']) ?>:</strong>
                                    <span class="rating"><?= str_repeat('⭐', $review['rating']) ?></span>
                                </p>
                                <p><?= htmlspecialchars($review['comment']) ?></p>
                                <p class="review-date"><?= htmlspecialchars($review['review_date']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Chưa có bình luận nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>