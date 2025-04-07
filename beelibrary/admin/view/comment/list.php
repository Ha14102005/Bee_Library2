<!-- header -->
<?php include(__DIR__ . '/../layout/header.php'); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <!-- navbar -->
        <?php include(__DIR__ . '/../layout/navbar.php'); ?>

        <!-- sidebar -->
        <?php include(__DIR__ . '/../layout/sidebar.php'); ?>

        <!-- content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lí Bình luận</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">DataTables</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                
                                </div>
                                <div class="card-body">
                                    <table border="1" cellpadding="10" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Người dùng</th>
                                                <th>Sách</th>
                                                <th>Đánh giá</th>
                                                <th>Bình luận</th>
                                                <th>Ngày bình luận</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comments as $comment): ?>
                                                <tr>
                                                    <td><?= $comment['comment_id']; ?></td>
                                                    <td><?= htmlspecialchars($comment['user_name']); ?></td>
                                                    <td><?= htmlspecialchars($comment['book_title']); ?></td>
                                                    <td><?= $comment['rating']; ?>/5</td>
                                                    <td><?= htmlspecialchars($comment['comment']); ?></td>
                                                    <td><?= $comment['review_date']; ?></td>
                                                    <td>
                                                        <a href="<?= BASE_URL_ADMIN ?>?act=delete-comment&id_comment=<?= $comment['comment_id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">Xóa</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include "./view/layout/footer.php" ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.toggle-desc').forEach(function(button) {
                    button.addEventListener('click', function() {
                        const container = this.previousElementSibling;
                        if (container.style.maxHeight === "none") {
                            container.style.maxHeight = "40px";
                            this.textContent = "Xem thêm";
                        } else {
                            container.style.maxHeight = "none";
                            this.textContent = "Thu gọn";
                        }
                    });
                });
            });
        </script>
</body>