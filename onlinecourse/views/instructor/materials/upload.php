<!-- Trang upload tài liệu cho bài học -->

<?php
    include_once __DIR__ . '/../../layouts/header.php';

    // Hiển thị thông báo nếu có
    if (isset($_GET['message'])) {
        $message = urldecode($_GET['message']);
        $alertClass = strpos($message, 'thành công') !== false ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show" role="alert">
                ' . htmlspecialchars($message) . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
?>

<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="fas fa-file-upload text-primary me-2"></i>
                        Quản lý tài liệu
                    </h2>
                    <p class="text-muted mb-0">
                        Bài học: <strong><?php echo htmlspecialchars($lesson['title']); ?></strong>
                        <span class="mx-2">•</span>
                        Khóa học: <strong><?php echo htmlspecialchars($course['title']); ?></strong>
                    </p>
                </div>
                <a href="index.php?controller=instructor&type=course&action=manage&course_id=<?php echo $course['id']; ?>"
                   class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Upload tài liệu mới
                    </h5>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=instructor&type=lesson&action=uploadMaterial" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="lesson_id" value="<?php echo htmlspecialchars($lesson['id']); ?>">
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">

                        <div class="mb-3">
                            <label class="form-label">Tên tài liệu</label>
                            <input type="text" class="form-control" name="title" placeholder="Nhập tên tài liệu" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Mô tả về tài liệu (tùy chọn)"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Chọn file</label>
                            <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar" required>
                            <div class="form-text">
                                Chấp nhận: PDF, Word, PowerPoint, Excel, Text, ZIP, RAR (tối đa 50MB)
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success" name="submit" value="Upload">
                                <i class="fas fa-upload me-2"></i>Upload tài liệu
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Materials -->
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-folder-open me-2"></i>Tài liệu hiện có
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    require_once 'models/Material.php';
                    $materialModel = new Material();
                    $materials = $materialModel->getAllMaterialsByLessonId($lesson['id']);
                        if (count($materials) > 0):
                    ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <i class="fas fa-file-<?php
                                                                          echo in_array(strtolower($material['file_type']), ['pdf']) ? 'pdf text-danger' :
                                                                          (in_array(strtolower($material['file_type']), ['doc', 'docx']) ? 'word text-primary' :
                                                                              (in_array(strtolower($material['file_type']), ['ppt', 'pptx']) ? 'powerpoint text-warning' :
                                                                              (in_array(strtolower($material['file_type']), ['xls', 'xlsx']) ? 'excel text-success' : 'alt text-muted')));
                                                                      ?> me-2"></i>
                                                <?php echo htmlspecialchars($material['file_name']); ?>
                                            </h6>
                                            <small class="text-muted">
                                                <?php echo date('d/m/Y H:i', strtotime($material['uploaded_at'])); ?> •
                                                <?php echo strtoupper($material['file_type']); ?>
                                            </small>
                                        </div>
                                        <div class="ms-2">
                                            <a href="uploads/materials/<?php echo htmlspecialchars($material['file_path']); ?>"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary me-1"
                                               title="Tải xuống">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form action="index.php?controller=instructor&type=lesson&action=deleteMaterial" method="post" class="d-inline">
                                                <input type="hidden" name="material_id" value="<?php echo $material['id']; ?>">
                                                <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        name="submit" value="Xóa"
                                                        title="Xóa"
                                                        onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có tài liệu nào</p>
                            <small class="text-muted">Tài liệu đã upload sẽ hiển thị ở đây</small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header {
    border-bottom: 2px solid #dee2e6;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    border-radius: 0.375rem;
}
</style>

<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>