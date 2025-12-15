<?php include_once __DIR__ . '/../../layouts/header.php'; ?>

<div class="container mt-4">

    <h4 class="mb-3">Danh sách học viên đã đăng ký khóa học</h4>

    <?php if (! empty($students)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tên học viên</th>
                        <th>Email</th>
                        <th>Khóa học đã đăng ký</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td><?php echo $index + 1 ?></td>
                            <td><?php echo htmlspecialchars($student['student_name']) ?></td>
                            <td><?php echo htmlspecialchars($student['email']) ?></td>
                            <td><?php echo htmlspecialchars($student['course_title']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Chưa có học viên nào đăng ký khóa học.
        </div>
    <?php endif; ?>

</div>

<?php include_once __DIR__ . '/../../layouts/footer.php'; ?>
