<!-- trang dashboard hien thi dau tien khi giang vien dang nhap -->

<?php include_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-3">Dashboard Giảng viên</h3>

            <p class="card-text">
                Chào mừng bạn đến với trang quản lý dành cho giảng viên.
            </p>

            <div class="d-flex gap-2">
                <a href="/CNWeb_BTH02/onlinecourse/index.php?controller=instructor&type=course&action=my_courses"
                    class="btn btn-primary">
                    Quản lý khóa học của tôi
                </a>

                <a href="/CNWeb_BTH02/onlinecourse/index.php?controller=instructor&type=course&action=students"
                    class="btn btn-success">
                    Xem danh sách học viên
                </a>
            </div>
        </div>
    </div>

</div>

<?php include_once __DIR__ . '/../layouts/footer.php'; ?>