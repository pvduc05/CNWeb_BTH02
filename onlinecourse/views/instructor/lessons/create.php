<!-- trang them bai hoc cho 1 khoa hoc -->

<?php 
    include_once __DIR__ . '/../../layouts/header.php';
?>

<form action="index.php?controller=instructor&type=lesson&action=store" method="post">
    <input type="hidden" name="course_id" value="<?php echo $_POST['course_id']; ?>">

    <input type="text" name="title" placeholder="Tên bài học"> <br>
    <textarea name="content" placeholder="Nội dung bài học"></textarea> <br>
    <input type="text" name="videoUrl" placeholder="Link video"> <br>
    <input type="text" name="orderLesson" placeholder="Thứ tự bài học"> <br>

    <input type="submit" class="btn btn-primary" name="submit" value="Thêm bài học">
</form>

<?php 
    include_once __DIR__ . '/../../layouts/footer.php';
?>