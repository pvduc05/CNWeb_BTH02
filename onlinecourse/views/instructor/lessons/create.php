<!-- trang them bai hoc cho 1 khoa hoc -->

<?php
include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus"></i> Thêm bài học mới
                </h5>
            </div>

            <div class="card-body">
                <form action="index.php?controller=instructor&type=lesson&action=store" method="post">
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($_POST['course_id'] ?? ''); ?>">

                    <div class="mb-3">
                        <label class="form-label">Tên bài học</label>
                        <input type="text" class="form-control"
                            name="title"
                            placeholder="Tên bài học"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung bài học</label>
                        <textarea class="form-control"
                            name="content"
                            placeholder="Nội dung bài học"
                            rows="4"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link video (YouTube, Vimeo, etc.)</label>
                        <input type="url" class="form-control"
                            name="videoUrl"
                            placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text">Để trống nếu không có video</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thứ tự bài học</label>
                        <input type="number" class="form-control"
                            name="orderLesson"
                            placeholder="Thứ tự bài học"
                            min="1"
                            required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success" name="submit" value="Thêm bài học">
                            <i class="fas fa-plus"></i> Thêm bài học
                        </button>

                        <a href="index.php?controller=instructor&type=course&action=manage&course_id=<?php echo htmlspecialchars($_POST['course_id'] ?? ''); ?>"
                            class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>