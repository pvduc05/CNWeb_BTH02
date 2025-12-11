<?php
// Đường dẫn cần căn chỉnh theo vị trí của AuthController.php
include __DIR__ . '/../../views/layouts/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header bg-primary text-white">Đăng Nhập</div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'registered'): ?>
                    <div class="alert alert-success">Đăng ký thành công! Hãy đăng nhập.</div>
                <?php endif; ?>

                <form action="index.php?controller=auth&action=login" method="POST">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng Nhập</button>
                </form>
                <p class="mt-3 text-center">Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../views/layouts/footer.php'; ?>