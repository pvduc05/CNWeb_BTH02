<?php include __DIR__ . '/../../views/layouts/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">Đăng Ký Tài Khoản</div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <form action="index.php?controller=auth&action=register" method="POST">
                    <div class="mb-3">
                        <label>Họ và Tên</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Đăng Ký</button>
                </form>
                <p class="mt-3 text-center">Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>