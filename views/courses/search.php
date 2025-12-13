<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

    <h3>Kết quả tìm kiếm</h3>

    <?php if (empty($course_search)): ?>
        <p class="text-muted">Không tìm thấy khóa học nào.</p>
    <?php else: ?>

        <div class="row mt-3">
            <?php foreach ($course_search as $c): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="assets/uploads/courses/<?= $c['image'] ?>" class="card-img-top" height="200" style="object-fit:cover">
                        <div class="card-body">
                            <h5><?= $c['title'] ?></h5>
                            <p><?= substr($c['description'], 0, 80) ?>...</p>
                            <a href="index.php?controller=course&action=detail&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>