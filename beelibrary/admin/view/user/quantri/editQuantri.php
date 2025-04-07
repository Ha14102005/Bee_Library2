<?php include('./view/layout/header.php'); ?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- navbar -->
        <?php include('./view/layout/navbar.php'); ?>
        <!-- sidebar -->
        <?php include('./view/layout/sidebar.php'); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cập nhật tài khoản quản trị viên</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a href="<?= BASE_URL_ADMIN . '?act=add-user' ?>">
                                    </a>
                                </div>
                                <form action="<?= BASE_URL_ADMIN ?>?act=sua-quan-tri" method="POST" class="p-4 border rounded bg-light">
                                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($quanTri['user_id']) ?>">

                                    <div class="form-group">
                                        <label for="username">Tên đăng nhập:</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($quanTri['username']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($quanTri['email']) ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Số điện thoại:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($quanTri['phone']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Vai trò:</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="admin" <?= $quanTri['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="customer" <?= $quanTri['role'] === 'customer' ? 'selected' : '' ?>>customer</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </form>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php include "./view/layout/footer.php" ?>
    </div>
</body>

</html>