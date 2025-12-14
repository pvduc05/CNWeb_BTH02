<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2><?php echo $course['title']; ?></h2>

    <div class="row mt-4">
        <div class="col-md-5">
            <img src="assets/uploads/courses/<?php echo $course['image']; ?>"
                class="img-fluid rounded shadow-sm">
        </div>

        <div class="col-md-7">
            <p><strong>Mô tả:</strong> <?php echo $course['description']; ?></p>

            <p><strong>Giảng viên:</strong> <?php echo $course['instructor_name']; ?></p>

            <p><strong>Danh mục:</strong> <?php echo $course['category_name']; ?></p>

            <p><strong>Thời lượng:</strong> <?php echo $course['duration_weeks']; ?> tuần</p>

            <p><strong>Cấp độ:</strong> <?php echo $course['level']; ?></p>

            <p><strong>Giá:</strong>
                <span class="text-danger fw-bold">
                    <?php echo number_format($course['price']); ?> USD
                </span>
            </p>
            <?php if (!isset($_SESSION['user'])): ?>

                <!-- Chưa đăng nhập -->
                <a href="index.php?controller=auth&action=login"
                    class="btn btn-warning">
                    Đăng nhập để đăng ký
                </a>

            <?php else: ?>

                <?php if ($isEnrolled): ?>
                    <!-- Đã đăng ký -->
                    <button class="btn btn-secondary" disabled>
                        Đã đăng ký
                    </button>
                <?php else: ?>
                    <!-- Chưa đăng ký -->
                    <a href="index.php?controller=enrollment&action=enroll&course_id=<?= $course['id'] ?>"
                        class="btn btn-success"
                        onclick="return confirm('Bạn có chắc muốn đăng ký khóa học này?')">
                        Đăng ký khóa học
                    </a>
                <?php endif; ?>

            <?php endif; ?>


        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>