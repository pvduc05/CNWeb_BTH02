<div class="container mt-4">

    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <h1 class="display-5">Chào mừng đến với OnlineCourse</h1>
        <p class="lead">Nền tảng học trực tuyến chuyên nghiệp – nhiều khóa học cho bạn lựa chọn.</p>
        <a href="index.php?controller=course&action=index" class="btn btn-primary btn-lg">Khám phá khóa học</a>
    </div>

    <h3 class="mb-4">Khóa học nổi bật</h3>

    <div class="row">
        <?php 
        // 1. Kiểm tra nếu có thông báo lỗi (tức là không có khóa học nào)
        if (!empty($message)): 
        ?>
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <?= $message ?>
                </div>
            </div>
        <?php 
        // 2. Nếu có khóa học, thì hiển thị danh sách
        elseif (isset($courses_home) && is_array($courses_home)): 
            foreach($courses_home as $c): 
        ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="assets/uploads/courses/<?= $c['image'] ?>" class="card-img-top" height="200" style="object-fit:cover">
                    <div class="card-body">
                        <h5><?= $c['title'] ?></h5>
                        <p class="text-muted small">Đăng ký: <?= $c['enrollment_count'] ?? 0 ?> lần</p>
                        <p><?= substr($c['description'],0,80) ?>...</p>
                        <a href="index.php?controller=course&action=detail&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php 
            endforeach; 
        endif; 
        ?>
    </div>

</div>