<!-- trang hien form them khoa hoc cua giang vien -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khoá học</title>
</head>

<body>
    <form action="index.php?controller=instructor&type=course&action=store" method="post">
        <input type="text" placeholder="Tên khoá học" name="title"> <br>
        <input type="text" placeholder="Mô tả" name="description"> <br>
        <input type="text" placeholder="Người đăng" name="instructorId"> <br>
        <input type="text" placeholder="Danh mục" name="categoryId"> <br>
        <input type="text" placeholder="Giá" name="price"> <br>
        <input type="text" placeholder="Thời gian khoá hoc (tuần)" name="durationWeeks"> <br>
        <input type="text" placeholder="Mức độ" name="level"> <br>
        <input type="text" placeholder="Ảnh" name="image"> <br>
        <input type="submit" value="Thêm khoá học" name="submit">
    </form>

    <button><a href="index.php?controller=instructor&type=course&action=my_courses">Xem danh sách khoá học</a></button>
</body>

</html>