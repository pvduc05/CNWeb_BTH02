<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Khóa học của tôi</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Đăng ký khóa học thành công!</div>
    <?php endif; ?>

    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-info">Cập nhật tiến độ thành công!</div>
    <?php endif; ?>

    <?php if (empty($myCourses)): ?>
        <div class="alert alert-warning">Bạn chưa đăng ký khóa học nào.</div>
    <?php else: ?>

        <div class="row">
            <?php foreach ($myCourses as $course): ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">

                        <div class="row g-0">

                            <!-- Ảnh khóa học -->
                            <div class="col-md-4">
                                <img src="assets/uploads/courses/<?php echo $course['image']; ?>" 
                                     class="img-fluid rounded-start"
                                     style="height: 150px; width: 100%; object-fit: cover;">
                            </div>

                            <!-- Nội dung khóa học -->
                            <div class="col-md-8">
                                <div class="card-body">

                                    <h5 class="card-title">
                                        <?php echo $course['title']; ?>
                                    </h5>

                                    <p class="text-muted">
                                        Trạng thái: 
                                        <span class="fw-bold 
                                            <?php echo $course['status'] == 'completed' ? 'text-success' : 'text-primary'; ?>">
                                            <?php echo ucfirst($course['status']); ?>
                                        </span>
                                    </p>

                                    <!-- Progress bar -->
                                    <p class="mb-1">Tiến độ học:</p>
                                    <div class="progress mb-2">
                                        <div class="progress-bar 
                                            <?php echo ($course['progress'] == 100 ? 'bg-success' : ''); ?>"
                                            role="progressbar"
                                            style="width: <?php echo $course['progress']; ?>%">
                                            <?php echo $course['progress']; ?>%
                                        </div>
                                    </div>

                                    <!-- Form cập nhật tiến độ -->
                                    <form action="index.php?controller=enrollment&action=update_progress" method="POST" class="mt-2">
                                        <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">

                                        <div class="input-group input-group-sm">
                                            <input type="number" name="progress" min="0" max="100" 
                                                   class="form-control" placeholder="Nhập % tiến độ">

                                            <button class="btn btn-outline-success" type="submit">
                                                Cập nhật
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Nút xem khóa học -->
                                    <a href="index.php?controller=course&action=detail&id=<?php echo $course['course_id']; ?>" 
                                       class="btn btn-primary btn-sm mt-3">
                                        Xem khóa học
                                    </a>

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
