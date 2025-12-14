<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-graduation-cap"></i> Khóa học của tôi</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Đăng ký khóa học thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Cập nhật tiến độ thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($myCourses)): ?>
        <div class="alert alert-warning">
            Bạn chưa đăng ký khóa học nào. <a href="index.php?controller=course&action=index">Tìm khóa học ngay</a>.
        </div>
    <?php else: ?>

        <div class="row">
            <?php foreach ($myCourses as $course): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="row g-0 h-100">
                            <div class="col-md-4">
                                <?php
                                $imgSrc = !empty($course['image']) ? 'assets/uploads/courses/' . $course['image'] : 'assets/uploads/no-image.jpg';
                                ?>
                                <img src="<?php echo $imgSrc; ?>"
                                    class="img-fluid rounded-start h-100"
                                    style="object-fit: cover; min-height: 200px;"
                                    alt="<?php echo $course['title']; ?>">
                            </div>

                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column h-100">
                                    <h5 class="card-title"><?php echo $course['title']; ?></h5>

                                    <p class="text-muted small mb-2">
                                        Trạng thái:
                                        <span class="fw-bold <?php echo $course['status'] == 'completed' ? 'text-success' : 'text-primary'; ?>">
                                            <?php echo ($course['status'] == 'completed') ? 'Hoàn thành' : 'Đang học'; ?>
                                        </span>
                                    </p>

                                    <div class="progress mb-2" style="height: 10px;">
                                        <div class="progress-bar <?php echo ($course['progress'] == 100 ? 'bg-success' : 'bg-info'); ?>"
                                            role="progressbar"
                                            style="width: <?php echo $course['progress']; ?>%">
                                        </div>
                                    </div>
                                    <small class="text-muted mb-3"><?php echo $course['progress']; ?>% hoàn thành</small>

                                    <div class="mt-auto">
                                        <a href="index.php?controller=student&action=course_progress&course_id=<?php echo $course['course_id']; ?>"
                                            class="btn btn-primary btn-sm w-100 mb-2">
                                            <i class="fas fa-play-circle"></i> Vào học
                                        </a>

                                        <form action="index.php?controller=enrollment&action=update_progress" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                            <input type="number" name="progress" min="0" max="100" class="form-control form-control-sm" placeholder="%" style="width: 70px;">
                                            <button class="btn btn-outline-secondary btn-sm" type="submit">Lưu</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>