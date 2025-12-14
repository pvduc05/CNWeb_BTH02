<!-- trang nay de hien thi danh sach khoa hoc ma giang vien da tao -->

<?php
    include_once __DIR__ . '/../layouts/header.php';

    if (isset($_GET['message'])) {
        $message    = urldecode($_GET['message']);
        $alertClass = strpos($message, 'thành công') !== false ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $alertClass . '">' . htmlspecialchars($message) . '</div>';
    }

    if (count($courses) === 0) {
        echo '<p>Không có khoá học nào!</p>';
    }
?>

<?php foreach ($courses as $course): ?>
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="row g-0">

                <!-- anh khoa hoc -->
                <div class="col-md-3">
                    <img src="assets/uploads/courses/<?php echo htmlspecialchars($course['image']) ?>"
                            class="img-fluid rounded-start"
                            alt="Course Image">
                </div>

                <!-- info khoa hoc -->
                <div class="col-md-9">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($course['title']) ?>
                        </h5>

                        <p class="card-text">
                            <?php echo htmlspecialchars($course['description']) ?>
                        </p>

                        <p class="mb-1">
                            <strong>Giá:</strong>                                                                                                                                                       <?php echo htmlspecialchars($course['price']) ?> |
                            <strong>Thời gian:</strong>                                                                                                                                                                            <?php echo htmlspecialchars($course['duration_weeks']) ?> tuần |
                            <strong>Mức độ:</strong>                                                                                                                                                                            <?php echo htmlspecialchars($course['level']) ?> |
                            <strong>Danh mục:</strong>                                                                                                                                                                         <?php echo htmlspecialchars($course['category_name'] ?? 'N/A') ?>
                        </p>

                        <p class="mb-2 text-muted">
                            Tạo ngày:                                                                                                                         <?php echo htmlspecialchars($course['created_at']) ?> |
                            Cập nhật ngày:                                                                                                                                              <?php echo htmlspecialchars($course['updated_at']) ?>
                        </p>

                        <!-- hanh dong -->
                        <div class="d-flex gap-2">
                            <form action="index.php?controller=instructor&type=course&action=edit" method="post">
                                <input type="hidden" name="course_id" value="<?php echo $course['id'] ?>">
                                <button class="btn btn-warning btn-sm">Sửa</button>
                            </form>

                            <form action="index.php?controller=instructor&type=course&action=delete" method="post">
                                <input type="hidden" name="course_id" value="<?php echo $course['id'] ?>">
                                <button class="btn btn-danger btn-sm" name="submit" value="Xoá">Xóa</button>
                            </form>

                            <form action="index.php?controller=instructor&type=course&action=manage" method="post">
                                <input type="hidden" name="course_id" value="<?php echo $course['id'] ?>">
                                <button class="btn btn-primary btn-sm">Quản lý</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="mt-3">
    <a href="index.php?controller=instructor&type=course&action=create" class="btn btn-primary">
        Thêm khóa học
    </a>
</div>

<?php
include_once __DIR__ . '/../layouts/footer.php';
?>