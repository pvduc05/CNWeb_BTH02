<?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] == 1 || $_SESSION['user']['role'] == 2)): ?>
<div class="col-md-3">

    <div class="list-group mb-4">
        <a class="list-group-item list-group-item-action active">Menu quản lý</a>

        <?php if ($_SESSION['user']['role'] == 1): ?>
            <a href="index.php?controller=instructor&action=dashboard" class="list-group-item">Dashboard</a>
            <a href="index.php?controller=instructor&action=my_courses" class="list-group-item">Khóa học của tôi</a>
            <a href="index.php?controller=instructor&action=create_course" class="list-group-item">Tạo khóa học</a>
            <a href="index.php?controller=instructor&action=lessons" class="list-group-item">Bài học</a>
        <?php endif; ?>

        <?php if ($_SESSION['user']['role'] == 2): ?>
            <a href="index.php?controller=admin&action=dashboard" class="list-group-item">Quản trị</a>
            <a href="index.php?controller=admin&action=users" class="list-group-item">Quản lý người dùng</a>
            <a href="index.php?controller=admin&action=categories" class="list-group-item">Quản lý danh mục</a>
            <a href="index.php?controller=admin&action=reports" class="list-group-item">Thống kê</a>
        <?php endif; ?>
    </div>

</div>
<?php endif; ?>
