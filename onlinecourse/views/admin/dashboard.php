<?php include 'views/layouts/header.php'; ?>
<div class="container" style="margin-top: 20px;">
    <h2>Bảng điều khiển Quản Trị Viên</h2>
    <p>Chào mừng quay trở lại, <strong><?php echo $_SESSION['user']['fullname']; ?></strong>!</p>

    <hr>

    <div class="stats-row" style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div class="card" style="border: 1px solid #ddd; padding: 20px; flex: 1; background: #f8f9fa;">
            <h3>Người dùng</h3>
            <p style="font-size: 24px; font-weight: bold;"><?php echo $totalUsers; ?></p>
            <small>Tổng số thành viên</small>
        </div>
        <div class="card" style="border: 1px solid #ddd; padding: 20px; flex: 1; background: #e3f2fd;">
            <h3>Khóa học</h3>
            <p style="font-size: 24px; font-weight: bold;"><?php echo $totalCourses; ?></p>
            <small>Đang hoạt động</small>
        </div>
        <div class="card" style="border: 1px solid #ddd; padding: 20px; flex: 1; background: #fff3cd;">
            <h3>Chờ duyệt</h3>
            <p style="font-size: 24px; font-weight: bold; color: #856404;"><?php echo $pendingCourses; ?></p>
            <small>Khóa học mới</small>
        </div>
    </div>

    <h3>Menu Quản lý</h3>
    <div class="management-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

        <div class="box">
            <h4>👤 Quản lý Người dùng</h4>
            <p>Xem danh sách, chỉnh sửa quyền, xóa hoặc vô hiệu hóa tài khoản.</p>
            <a href="index.php?controller=admin&action=users" class="btn">Truy cập</a>
        </div>

        <div class="box">
            <h4>📂 Danh mục Khóa học</h4>
            <p>Tạo mới, sửa tên hoặc xóa các danh mục khóa học.</p>
            <a href="index.php?controller=admin&action=categories" class="btn">Truy cập</a>
        </div>

        <div class="box">
            <h4>✅ Duyệt Khóa học</h4>
            <p>Xem xét và phê duyệt các khóa học do giảng viên đăng tải.</p>
            <a href="index.php?controller=admin&action=approve_courses" class="btn">Truy cập</a>
        </div>

        <div class="box">
            <h4>📊 Thống kê Hệ thống</h4>
            <p>Xem báo cáo doanh thu, lượng truy cập và đăng ký mới.</p>
            <a href="index.php?controller=admin&action=statistics" class="btn">Truy cập</a>
        </div>

    </div>
</div>

<style>
    /* CSS nội bộ đơn giản để demo bố cục */
    .box {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 5px;
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        background: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 10px;
    }

    .btn:hover {
        background: #0056b3;
    }
</style>

<?php include 'views/layouts/footer.php'; ?>