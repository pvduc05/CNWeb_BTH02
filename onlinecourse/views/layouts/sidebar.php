<div class="col-md-3">
    <div class="list-group mb-4">

        <a href="index.php" class="list-group-item list-group-item-action fw-bold">
            <i class="bi bi-house"></i> Trang chủ
        </a>

        <?php if (isset($_SESSION['user'])): ?>

            <div class="list-group-item list-group-item-secondary">
                Xin chào, <strong><?= $_SESSION['user']['fullname'] ?></strong>
            </div>

            <?php if ($_SESSION['user']['role'] == 0): ?>
                <a href="index.php?controller=student&action=dashboard"
                    class="list-group-item list-group-item-action">
                    Dashboard
                </a>

                <a href="index.php?controller=student&action=my_courses"
                    class="list-group-item list-group-item-action">
                    Khóa học của tôi
                </a>

                <a href="index.php?controller=student&action=progress"
                    class="list-group-item list-group-item-action">
                    Tiến độ học tập
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['user']['role'] == 1): ?>
                <a href="index.php?controller=instructor&action=dashboard"
                    class="list-group-item list-group-item-action list-group-item-warning">
                    Bảng điều khiển Giảng viên
                </a>
                <a href="index.php?controller=instructor&action=manage_courses"
                    class="list-group-item list-group-item-action">
                    Quản lý khóa học
                </a>
                <a href="index.php?controller=instructor&action=create_course"
                    class="list-group-item list-group-item-action">
                    Tạo khóa học mới
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['user']['role'] == 2): ?>
                <a href="index.php?controller=admin&action=dashboard"
                    class="list-group-item list-group-item-action list-group-item-danger">
                    Quản trị hệ thống
                </a>
                <a href="index.php?controller=admin&action=users"
                    class="list-group-item list-group-item-action">
                    Quản lý người dùng
                </a>
                <a href="index.php?controller=admin&action=categories"
                    class="list-group-item list-group-item-action">
                    Quản lý danh mục
                </a>
            <?php endif; ?>

            <a href="index.php?controller=auth&action=logout"
                class="list-group-item list-group-item-action text-danger mt-2">
                Đăng xuất
            </a>

        <?php else: ?>
            <a href="index.php?controller=auth&action=login"
                class="list-group-item list-group-item-action list-group-item-primary">
                Đăng nhập
            </a>
            <a href="index.php?controller=auth&action=register"
                class="list-group-item list-group-item-action">
                Đăng ký tài khoản
            </a>
        <?php endif; ?>

    </div>
</div>