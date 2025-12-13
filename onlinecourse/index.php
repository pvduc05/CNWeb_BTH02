<?php
session_start(); // Bắt buộc phải có để dùng $_SESSION

// Router đơn giản
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'home':
        include 'controllers/HomeController.php';
        $homeController = new HomeController();
        $homeController->index();
        break;

    case 'auth':
        include 'controllers/AuthController.php';
        $auth = new AuthController();
        if ($action == 'login') $auth->login();
        elseif ($action == 'register') $auth->register();
        elseif ($action == 'logout') $auth->logout();
        break;

    case 'student':
        // Kiểm tra quyền trước khi vào Controller này
        checkRole(0);
        // include 'controllers/StudentController.php'; ...
        include 'views/student/dashboard.php'; // Tạm thời hiển thị view
        break;

    case 'instructor':
        checkRole(1);
        include 'views/instructor/dashboard.php';
        break;

    case 'admin':
        checkRole(2); // Chỉ Admin mới vào được
        require_once 'controllers/AdminController.php';
        $adminController = new AdminController();
        switch ($action) {
            // 1. Quản lý User
            case 'users':
                $adminController->manageUsers();
                break;
            case 'edit_user':
                $adminController->editUser();
                break;
            case 'delete_user':
                $adminController->deleteUser();
                break;

            // 2. Quản lý Danh mục (Categories)
            case 'categories':          // Xem danh sách
                $adminController->listCategories();
                break;
            case 'create_category':     // Form thêm mới & Xử lý thêm
                $adminController->createCategory();
                break;
            case 'edit_category':       // Form sửa & Xử lý sửa
                $adminController->editCategory();
                break;
            case 'delete_category':     // Xử lý xóa
                $adminController->deleteCategory();
                break;

            // 3. Các chức năng khác (Để nút bấm trên Dashboard hoạt động)
            // case 'approve_courses':     // Duyệt khóa học
            //     $adminController->approveCourses();
            //     break;
            // case 'statistics':          // Thống kê
            //     $adminController->statistics();
            //     break;
            // Mặc định: Về Dashboard Admin
            case 'dashboard':
            default:
                $adminController->dashboard();
                break;
        }
        break;
    default:
        echo "404 Not Found";
        break;
}

// Hàm kiểm tra quyền đơn giản
function checkRole($requiredRole)
{
    if (!isset($_SESSION['user'])) {
        header("Location: index.php?controller=auth&action=login");
        exit();
    }
    // Nếu là Admin (2) thì có thể vào tất cả, hoặc so sánh chính xác
    if ($_SESSION['user']['role'] != $requiredRole && $_SESSION['user']['role'] != 2) {
        echo "Bạn không có quyền truy cập trang này!";
        exit();
    }
}
