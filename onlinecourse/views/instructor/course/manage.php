<!-- Trang quan ly 1 khoa hoc cu the -->

<?php
    include_once __DIR__ . '/../../layouts/header.php';
?>

<div class="container-fluid mt-4">
    <!-- Course Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body p-0">
                    <div class="row g-0 align-items-center">
                        <!-- Course Image -->
                        <div class="col-lg-4 col-md-5">
                            <div class="position-relative">
                                <?php if ($course['image']): ?>
                                    <img src="assets/uploads/courses/<?php echo htmlspecialchars($course['image']); ?>"
                                         alt="Ảnh khóa học"
                                         class="img-fluid rounded-start w-100"
                                         style="height: 250px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-gradient bg-primary d-flex align-items-center justify-content-center rounded-start text-white"
                                         style="height: 250px;">
                                        <div class="text-center">
                                            <i class="fas fa-graduation-cap fa-4x mb-3"></i>
                                            <h5>Khóa học</h5>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- Status Badge -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge fs-6 px-3 py-2
                                        <?php
                                            echo $course['level'] == 'Beginner' ? 'bg-success' :
                                        ($course['level'] == 'Intermediate' ? 'bg-warning text-dark' : 'bg-danger');
                                        ?>">
                                        <i class="fas fa-signal me-1"></i><?php echo htmlspecialchars($course['level']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="col-lg-8 col-md-7">
                            <div class="p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h2 class="card-title mb-2 fw-bold"><?php echo htmlspecialchars($course['title']); ?></h2>
                                        <p class="text-muted mb-3 lead"><?php echo htmlspecialchars($course['description']); ?></p>
                                    </div>
                                    <div class="text-end">
                                        <h3 class="text-primary fw-bold mb-0"><?php echo number_format($course['price']); ?> VND</h3>
                                        <small class="text-muted">Giá khóa học</small>
                                    </div>
                                </div>

                                <!-- Course Stats -->
                                <div class="row g-3 mb-4">
                                    <div class="col-md-3 col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-clock text-primary fa-2x mb-2"></i>
                                            <div class="fw-bold"><?php echo htmlspecialchars($course['duration_weeks']); ?> tuần</div>
                                            <small class="text-muted">Thời gian</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-book-open text-success fa-2x mb-2"></i>
                                            <div class="fw-bold"><?php echo count($lessons); ?></div>
                                            <small class="text-muted">Bài học</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-tags text-info fa-2x mb-2"></i>
                                            <div class="fw-bold"><?php echo htmlspecialchars($course['category_name'] ?? 'N/A'); ?></div>
                                            <small class="text-muted">Danh mục</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="text-center p-3 bg-light rounded">
                                            <i class="fas fa-calendar text-warning fa-2x mb-2"></i>
                                            <div class="fw-bold"><?php echo date('d/m/Y', strtotime($course['created_at'])); ?></div>
                                            <small class="text-muted">Ngày tạo</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex flex-wrap gap-2">
                                    <form action="index.php?controller=instructor&type=lesson&action=create" method="post" class="d-inline">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-lg" name="submit" value="Thêm bài học">
                                            <i class="fas fa-plus-circle me-2"></i>Thêm bài học
                                        </button>
                                    </form>

                                    <form action="index.php?controller=instructor&type=course&action=edit" method="post" class="d-inline">
                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                        <button type="submit" class="btn btn-warning btn-lg">
                                            <i class="fas fa-edit me-2"></i>Sửa khóa học
                                        </button>
                                    </form>

                                    <a href="index.php?controller=instructor&type=course&action=my_courses" class="btn btn-outline-secondary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lessons Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-ul me-2"></i>Danh sách bài học
                        <span class="badge bg-light text-dark ms-2"><?php echo count($lessons); ?> bài</span>
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light btn-sm" onclick="location.reload()">
                            <i class="fas fa-sync-alt"></i> Làm mới
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (count($lessons) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th width="25%">Bài học</th>
                                        <th width="30%">Nội dung</th>
                                        <th width="15%">Video</th>
                                        <th width="8%" class="text-center">Thứ tự</th>
                                        <th width="17%" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lessons as $key => $lesson): ?>
                                        <tr class="lesson-row">
                                            <td class="text-center fw-bold"><?php echo $key + 1; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="lesson-icon me-3">
                                                        <i class="fas fa-play-circle text-primary fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($lesson['title']); ?></h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            <?php echo date('d/m/Y H:i', strtotime($lesson['created_at'] ?? 'now')); ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="lesson-content">
                                                    <p class="mb-0 text-truncate" style="max-width: 300px;" title="<?php echo htmlspecialchars($lesson['content']); ?>">
                                                        <?php echo htmlspecialchars($lesson['content']); ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($lesson['video_url']): ?>
                                                    <a href="<?php echo htmlspecialchars($lesson['video_url']); ?>"
                                                       target="_blank"
                                                       class="btn btn-sm btn-outline-primary w-100">
                                                        <i class="fab fa-youtube me-1"></i>Xem video
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary w-100">
                                                        <i class="fas fa-video-slash me-1"></i>Không có video
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info fs-6 px-3 py-2"><?php echo htmlspecialchars($lesson['order_lesson']); ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group w-100" role="group">
                                                    <form action="index.php?controller=instructor&type=lesson&action=edit" method="post" class="flex-fill">
                                                        <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-warning btn-sm w-100" title="Chỉnh sửa bài học">
                                                            <i class="fas fa-edit me-1"></i>Sửa
                                                        </button>
                                                    </form>

                                                    <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" title="Quản lý">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="index.php?controller=instructor&type=lesson&action=materials" method="post" class="d-inline w-100">
                                                                <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">

                                                                <button type="submit"
                                                                value="Đăng tải"
                                                                class="dropdown-item">
                                                                    <i class="fas fa-file-upload me-2"></i>Quản lý bài học
                                                                </button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="index.php?controller=instructor&type=lesson&action=delete" method="post" class="d-inline w-100"
                                                                  onsubmit="return confirm('Bạn có chắc muốn xóa bài học này?')">
                                                                <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">
                                                                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                                <button type="submit" class="dropdown-item text-danger" name="submit" value="Xóa">
                                                                    <i class="fas fa-trash me-2"></i>Xóa bài học
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-book-open fa-5x text-muted mb-4"></i>
                                <h4 class="text-muted mb-3">Chưa có bài học nào</h4>
                                <p class="text-muted mb-4">Hãy tạo bài học đầu tiên để bắt đầu xây dựng nội dung khóa học của bạn.</p>
                                <form action="index.php?controller=instructor&type=lesson&action=create" method="post" class="d-inline">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-lg" name="submit" value="Thêm bài học">
                                        <i class="fas fa-plus-circle me-2"></i>Tạo bài học đầu tiên
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.lesson-row:hover {
    background-color: #f8f9fa !important;
}

.lesson-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e9ecef;
    border-radius: 50%;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

.dropdown-menu {
    min-width: 180px;
}

.empty-state {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-header {
    border-bottom: 2px solid #dee2e6;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.badge {
    font-size: 0.75rem;
}
</style>

<?php
include_once __DIR__ . '/../../layouts/footer.php';
?>