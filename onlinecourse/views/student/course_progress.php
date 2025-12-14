<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
   <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?controller=student&action=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?controller=enrollment&action=my_courses">Khóa học của tôi</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $course['title'] ?></li>
    </ol>
</nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <?php
                $imgSrc = !empty($course['image']) ? 'assets/uploads/courses/' . $course['image'] : 'assets/uploads/no-image.jpg';
                ?>
                <img src="<?= $imgSrc ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $course['title'] ?></h5>
                    <hr>
                    <p class="mb-1">Tiến độ hiện tại:</p>
                    <div class="progress mb-2" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $progress ?>%">
                            <?= $progress ?>%
                        </div>
                    </div>

                    <form method="POST" action="index.php?controller=enrollment&action=update_progress" class="mt-3">
                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Cập nhật tiến độ thủ công (%):</label>
                            <div class="input-group">
                                <input type="number" name="progress" class="form-control" min="0" max="100" value="<?= $progress ?>">
                                <button class="btn btn-success" type="submit">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Nội dung khóa học</h4>
                </div>
                <div class="card-body">
                    <?php if (empty($lessons)): ?>
                        <p class="text-muted text-center py-3">Chưa có bài học nào được cập nhật.</p>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($lessons as $index => $l): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge bg-secondary me-2">Bài <?= $index + 1 ?></span>
                                        <strong><?= htmlspecialchars($l['title']) ?></strong>
                                    </div>

                                    <!-- <a href="index.php?controller=lesson&action=view&id=<?= $l['id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-play"></i> Học ngay
                                    </a> -->
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>