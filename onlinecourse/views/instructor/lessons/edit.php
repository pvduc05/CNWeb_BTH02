<!-- trang chinh sua bai hoc -->

<?php
    include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit"></i> Chỉnh sửa bài học
                </h5>
            </div>

            <div class="card-body">
                <form action="index.php?controller=instructor&type=lesson&action=update" method="post">
                    <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson['id']); ?>">
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($lesson['course_id']); ?>">

                    <div class="mb-3">
                        <label class="form-label">Tên bài học</label>
                        <input type="text" class="form-control"
                               name="title"
                               placeholder="Tên bài học"
                               value="<?php echo htmlspecialchars($lesson['title']); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung bài học</label>
                        <textarea class="form-control"
                                  name="content"
                                  placeholder="Nội dung bài học"
                                  rows="4"
                                  required><?php echo htmlspecialchars($lesson['content']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link video (YouTube, Vimeo, etc.)</label>
                        <input type="url" class="form-control"
                               name="videoUrl"
                               placeholder="https://www.youtube.com/watch?v=..."
                               value="<?php echo htmlspecialchars($lesson['video_url']); ?>">
                        <div class="form-text">Để trống nếu không có video</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thứ tự bài học</label>
                        <input type="number" class="form-control"
                               name="orderLesson"
                               placeholder="Thứ tự bài học"
                               value="<?php echo htmlspecialchars($lesson['order_lesson']); ?>"
                               min="1"
                               required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success" name="submit" value="Cập nhật bài học">
                            <i class="fas fa-save"></i> Cập nhật bài học
                        </button>

                        <a href="index.php?controller=instructor&type=course&action=manage&course_id=<?php echo $lesson['course_id']; ?>"
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