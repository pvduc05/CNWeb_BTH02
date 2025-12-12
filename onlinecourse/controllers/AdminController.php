<?php
require_once 'models/User.php';
// Sau này bạn sẽ cần require thêm: models/Course.php, models/Category.php
class AdminController
{
    private $userModel;

    public function __construct()
    {
        // Không cần session_start() hay checkRole() ở đây nữa
        // Vì index.php đã lo việc đó rồi.
        $this->userModel = new User();
    }

    // Trang Dashboard (Mặc định)
    public function dashboard()
    {
        // 1. Lấy thống kê sơ bộ (Ví dụ: đếm số user)
        // Đây là ví dụ, bạn có thể viết thêm hàm countAll() trong User Model
        $users = $this->userModel->getAllUsers()->fetchAll();
        $totalUsers = count($users);

        // 2. Các thống kê khác (Khóa học, Doanh thu...) tạm thời để số giả định hoặc 0
        $totalCourses = 0;
        $pendingCourses = 0;

        // 3. Hiển thị View Dashboard
        include 'views/admin/dashboard.php';
    }
    // --- QUẢN LÝ USER ---

    // 1. Danh sách User
    public function manageUsers()
    {
        $stmt = $this->userModel->getAllUsers();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/admin/users/manage.php';
    }

    // 2. Chỉnh sửa User
    public function editUser()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$id) {
            header('Location: index.php?controller=admin&action=users');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Chú ý: Cần lấy ID từ POST hoặc GET để update chính xác
            // Ở form edit.php nên để action="...&id=..." hoặc input hidden

            if ($this->userModel->update($id, $fullname, $email, $role)) {
                header('Location: index.php?controller=admin&action=users&status=success');
                exit();
            } else {
                $error = "Cập nhật thất bại.";
            }
        }

        $user = $this->userModel->getUserById($id);
        include 'views/admin/users/edit.php';
    }

    // 3. Xóa User
    public function deleteUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if ($this->userModel->delete($id)) {
                header('Location: index.php?controller=admin&action=users&status=deleted');
            } else {
                header('Location: index.php?controller=admin&action=users&status=error');
            }
        } else {
            header('Location: index.php?controller=admin&action=users');
        }
        exit();
    }
    // --- 2. QUẢN LÝ DANH MỤC (Placeholder) ---
    public function manageCategories()
    {
        // Logic lấy danh mục từ Model Category
        // include 'views/admin/categories/list.php';
        echo "Tính năng Quản lý danh mục đang phát triển";
    }
    // --- 3. DUYỆT KHÓA HỌC (Placeholder) ---
    public function approveCourses()
    {
        // Logic lấy các khóa học có status = 'pending'
        // include 'views/admin/courses/approve.php';
        echo "Tính năng Duyệt khóa học đang phát triển";
    }
    // --- 4. THỐNG KÊ CHI TIẾT (Placeholder) ---
    public function statistics()
    {
        // include 'views/admin/reports/statistics.php';
        echo "Trang thống kê chi tiết";
    }
}
