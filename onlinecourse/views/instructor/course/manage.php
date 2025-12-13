<!-- Trang quan ly 1 khoa hoc cu the -->

<?php
    include_once __DIR__ . '/../../layouts/header.php';
?>


<div class="container">
    <div class="course-info">
        <h4>Thông tin về khoá học</h4>
        <p><?php echo htmlspecialchars($course['title']); ?></p>
        <p><?php echo htmlspecialchars($course['description']); ?></p>
        <p><?php echo htmlspecialchars($course['instructor_id']); ?></p>
        <p><?php echo htmlspecialchars($course['category_id']); ?></p>
        <p><?php echo htmlspecialchars($course['price']); ?></p>
        <p><?php echo htmlspecialchars($course['duration_weeks']); ?></p>
        <p><?php echo htmlspecialchars($course['level_course']); ?></p>
        <img src="<?php echo htmlspecialchars($course['image']); ?>" alt="Ảnh khoá học">
    </div>

    <form action="index.php?controller=instructor&type=lesson&action=create" method="post">
        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
        <input type="submit" class="btn btn-primary mb-3" name="submit" value="Thêm bài học">
    </form>

    <div class="lessons">
        <table border="1">
            <thead>
                <th>STT</th>
                <th>Tên bài học</th>
                <th>Nội dung</th>
                <th>Link video</th>
                <th>Thứ tự bài học</th>
            </thead>

            <tbody>
                <?php foreach ($lessons as $key => $lesson): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                        <td><?php echo htmlspecialchars($lesson['content']); ?></td>
                        <td><?php echo htmlspecialchars($lesson['video_url']); ?></td>
                        <td><?php echo htmlspecialchars($lesson['order_lesson']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>


<?php
    include_once __DIR__ . '/../../layouts/footer.php';
?>