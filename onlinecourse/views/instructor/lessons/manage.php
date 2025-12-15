<!-- Đây là trang hiển thị các loại tài liệu của 1 bài học trong 1 khoá học -->

<?php 
include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="index.php?controller=instructor&type=course&action=manage&course_id=<?= $courseId ?>"
               class="btn btn-secondary btn-sm">
                ← Quay lại
            </a>

            <h4 class="mb-0">
                <?= htmlspecialchars($lesson['title']) ?>
            </h4>
        </div>

        <a href="index.php?controller=instructor&type=lesson&action=upload&lesson_id=<?= $lesson['id'] ?>&course_id=<?= $courseId ?>"
           class="btn btn-success">
            + Thêm tài liệu
        </a>
    </div>

    <!-- Thông tin bài học -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title mb-2">
                <?= htmlspecialchars($lesson['title']) ?>
            </h4>
            <p class="text-muted mb-0">
                Tài liệu của bài học
            </p>
        </div>
    </div>

    <!-- Danh sách tài liệu -->
    <?php if (!empty($materials)): ?>
        <div class="list-group">
            <?php foreach ($materials as $material): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">
                            <?= htmlspecialchars($material['filename']) ?>
                        </h6>
                        <small class="text-muted">
                            Loại file: <?= htmlspecialchars($material['file_type']) ?>
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="assets/uploads/materials/<?= htmlspecialchars($material['file_path']) ?>"
                           class="btn btn-sm btn-primary"
                           target="_blank">
                            Xem
                        </a>

                        <a href="assets/uploads/materials/<?= htmlspecialchars($material['file_path']) ?>"
                           class="btn btn-sm btn-success"
                           download>
                            Tải
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Chưa có tài liệu cho bài học này.
        </div>
    <?php endif; ?>

</div>


<?php 
include_once __DIR__ . '/../../layouts/footer.php';
?>