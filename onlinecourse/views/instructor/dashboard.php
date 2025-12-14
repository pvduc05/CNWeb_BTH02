<!-- trang dashboard hien thi dau tien khi giang vien dang nhap -->

<?php
include_once __DIR__ . '/../layouts/header.php';
?>

<p>Đây là trang dashboard của giảng viên</p>

<button><a href="/CNWeb_BTTH02/onlinecourse/index.php?controller=instructor&type=course&action=my_courses">
        Quản lý khoá học của tôi
    </a></button>

<?php
include_once __DIR__ . '/../layouts/footer.php';
?>