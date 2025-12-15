<!-- Trang upload tài liệu cho bài học -->

<?php
    include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            Thêm tài liệu cho bài học
        </div>

        <form action="index.php?controller=instructor&type=lesson&action=upload_material"
              method="post"
              enctype="multipart/form-data">

            <!-- hidden data -->
            <input type="hidden" name="lesson_id" value="<?= htmlspecialchars($lesson['id']) ?>">
            <input type="hidden" name="course_id" value="<?= htmlspecialchars($couseId) ?>">

            <div class="mb-3">
                <label class="form-label">Tên tài liệu</label>
                <input type="text"
                    name="filename"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Chọn file</label>
                <input type="file"
                    name="file"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Loại file</label>
                <select name="file_type" class="form-select" required>
                    <option value="pdf">PDF</option>
                    <option value="doc">DOC</option>
                    <option value="ppt">PPT</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success" name="submit">
                    Tải tài liệu
                </button>

                <a href="index.php?controller=instructor&type=lesson&action=materials&lesson_id=<?= htmlspecialchars($lesson['id']) ?>&course_id=<?= htmlspecialchars($courseId) ?>"
                class="btn btn-secondary">
                    Quay lại
                </a>
            </div>
        </form>
    </div>

</div>

<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>