<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Xin chào, <?= $_SESSION['user']['fullname'] ?? 'Học viên' ?>!</h1>
                    <p class="col-md-8 fs-4">Chào mừng bạn quay trở lại hệ thống học trực tuyến.</p>

                    <hr class="my-4">

                    <div class="d-flex gap-3">
                        <a href="index.php?controller=enrollment&action=my_courses" class="btn btn-primary btn-lg">
                            <i class="fas fa-book-reader"></i> Vào học ngay
                        </a>
                        <a href="index.php?controller=course&action=index" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-search"></i> Tìm khóa học mới
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Thông báo</div>
                        <div class="card-body">
                            <p class="card-text">Hệ thống vừa cập nhật thêm các khóa học mới về lập trình PHP.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>