<?php
// Đảm bảo đường dẫn này đúng so với vị trí file index.php
require_once 'models/User.php';
require_once 'models/Category.php';

class AdminController
{
    private $userModel;
    private $categoryModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->categoryModel = new Category();
    }

    // --- TRANG DASHBOARD ---
    public function dashboard()
    {
        // 1. Lấy thống kê User
        $stmt = $this->userModel->getAllUsers();
        // Kiểm tra xem query có chạy đúng không
        if ($stmt) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $totalUsers = count($users);
        } else {
            $totalUsers = 0;
        }

        // 2. Thống kê giả định (Sau này thay bằng Model Course)
        $totalCourses = 0;
        $pendingCourses = 0;

        // 3. Gọi View (Quan trọng: File này phải tồn tại)
        if (file_exists('views/admin/dashboard.php')) {
            include 'views/admin/dashboard.php';
        } else {
            echo "Lỗi: Không tìm thấy file views/admin/dashboard.php";
        }
    }

    // --- QUẢN LÝ USER ---
    public function manageUsers()
    {
        $stmt = $this->userModel->getAllUsers();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/admin/users/manage.php';
    }

    public function editUser()
    {
        // Nếu là POST (người dùng bấm Lưu từ Modal)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            if ($this->userModel->update($id, $fullname, $email, $role)) {
                // Thành công -> Quay lại trang danh sách
                header('Location: index.php?controller=admin&action=users&status=success');
            } else {
                // Thất bại -> Quay lại và báo lỗi
                header('Location: index.php?controller=admin&action=users&status=error');
            }
            exit();
        }

        // Nếu cố tình truy cập bằng GET, đẩy về trang danh sách
        header('Location: index.php?controller=admin&action=users');
        exit();
    }

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
    }

    // --- QUẢN LÝ DANH MỤC (CATEGORY) ---
    public function listCategories()
    {
        $stmt = $this->categoryModel->getAll();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include 'views/admin/categories/list.php';
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->name = $_POST['name'];
            $this->categoryModel->description = $_POST['description'];

            if ($this->categoryModel->create()) {
                header('Location: index.php?controller=admin&action=categories&msg=success');
            } else {
                $error = "Tạo thất bại!";
                include 'views/admin/categories/create.php';
            }
        } else {
            include 'views/admin/categories/create.php';
        }
    }

    public function editCategory()
    {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->categoryModel->id = $id;
            $this->categoryModel->name = $_POST['name'];
            $this->categoryModel->description = $_POST['description'];

            if ($this->categoryModel->update()) {
                header('Location: index.php?controller=admin&action=categories&msg=updated');
                exit();
            } else {
                $error = "Cập nhật thất bại!";
            }
        }

        // Lấy dữ liệu cũ
        $category = $this->categoryModel->getById($id);

        // Kiểm tra xem có lấy được category không trước khi include view
        if (!$category) {
            echo "Không tìm thấy danh mục!";
            exit();
        }

        include 'views/admin/categories/edit.php';
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if ($this->categoryModel->delete($id)) {
                header('Location: index.php?controller=admin&action=categories&msg=deleted');
            }
        }
    }

    // --- CÁC HÀM BỊ THIẾU (CẦN THÊM VÀO ĐỂ KHÔNG BỊ LỖI) ---

    // 1. Duyệt khóa học
    public function approveCourses()
    {
        // Tạm thời hiển thị thông báo
        echo "<h1>Trang duyệt khóa học (Đang phát triển)</h1>";
        echo "<a href='index.php?controller=admin&action=dashboard'>Quay lại</a>";
        // Sau này: include 'views/admin/courses/approve.php';
    }

    // 2. Thống kê
    public function statistics()
    {
        echo "<h1>Trang thống kê (Đang phát triển)</h1>";
        echo "<a href='index.php?controller=admin&action=dashboard'>Quay lại</a>";
        // Sau này: include 'views/admin/reports/statistics.php';
    }
}
