<div class="container mt-4">
    <h3>Tiến độ khóa học</h3>

    <p>Khóa học: <strong><?= $course['title'] ?></strong></p>

    <p>Tiến độ của bạn: <?= $progress ?>%</p>

    <form method="POST" action="/enroll/update_progress">
        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
        <input type="number" name="progress" class="form-control w-25" min="0" max="100">
        <button class="btn btn-success mt-2">Cập nhật tiến độ</button>
    </form>

    <hr>

    <h4>Bài học</h4>

    <?php foreach ($lessons as $l): ?>
        <div class="mb-3">
            <h5><?= $l['title'] ?></h5>
            <a href="/lesson/view?id=<?= $l['id'] ?>" class="btn btn-outline-primary btn-sm">Xem bài học</a>
        </div>
    <?php endforeach; ?>
</div>
