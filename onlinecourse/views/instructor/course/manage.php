<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khoá học</title>
</head>
<body>
    <h1>Quản lý khoá học</h1>
    <p>Chào mừng bạn đến với trang quản lý khoá học của giảng viên.</p>

    <?php
        if (isset($_SESSION['msg'])) {
            echo '<p>' . htmlspecialchars($_SESSION['msg']) . '</p>';
            unset($_SESSION['msg']);
        }
    ?>

    <table border="1">
        <thead>
            <th>STT</th>
            <th>Tên khoá học</th>
            <th>Mô tả</th>
            <th>Người đăng</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Thời gian khoá học (tuần)</th>
            <th>Mức độ</th>
            <th>Ảnh</th>
            <th>Được tạo vào ngày</th>
            <th>Được cập nhật vào ngày</th>
            <th>Hành động</th>
        </thead>
        <tbody>
            <?php foreach ($courses as $key => $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($key); ?></td>
                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                    <td><?php echo htmlspecialchars($course['description']); ?></td>
                    <td><?php echo htmlspecialchars($course['instructor_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['category_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['price']); ?></td>
                    <td><?php echo htmlspecialchars($course['duration_weeks']); ?></td>
                    <td><?php echo htmlspecialchars($course['level_course']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($course['image']); ?>" alt="Course Image" width="100"></td>
                    <td><?php echo htmlspecialchars($course['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($course['updated_at']); ?></td>
                    <th>
                        <form action="index.php?action=delete" method="post">
                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                            <input type="submit" value="Xoá" name="submit">
                        </form>

                        <form action="index.php?action=edit" method="post">
                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']) ?>">
                            <input type="submit" value="Sửa" name="submit">
                        </form>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <button><a href="index.php?action=create">Thêm khoá học</a></button>
</body>
</html>
