<!-- trang chinh sua khoa hoc cua giang vien -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa khoá học</title>
</head>
<body>
    <form action="index.php?controller=instructor&type=course&action=update" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">
        <input type="text" placeholder="Tên khoá học" name="title" value="<?php echo htmlspecialchars($course['title']) ?>"> <br>
        <input type="text" placeholder="Mô tả" name="description" value="<?php echo htmlspecialchars($course['description']) ?>"> <br>
        <input type="text" placeholder="Người đăng" name="instructorId" value="<?php echo htmlspecialchars($course['instructor_id']) ?>"> <br>
        <input type="text" placeholder="Danh mục" name="categoryId" value="<?php echo htmlspecialchars($course['category_id']) ?>"> <br>
        <input type="text" placeholder="Giá" name="price" value="<?php echo htmlspecialchars($course['price']) ?>"> <br>
        <input type="text" placeholder="Thòi gian khoá hoc (tuần)" name="durationWeeks" value="<?php echo htmlspecialchars($course['duration_weeks']) ?>"> <br>
        <input type="text" placeholder="Mức độ" name="level" value="<?php echo htmlspecialchars($course['level_course']) ?>"> <br>
        <input type="text" placeholder="Ảnh" name="image" value="<?php echo htmlspecialchars($course['image']) ?>"> <br>
        <input type="submit" value="Sửa khoá học" name="submit">
    </form>
</body>
</html>