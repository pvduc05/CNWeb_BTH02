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
        checkRole(2);
        require_once 'controllers/AdminController.php';
        $adminController = new AdminController();

        switch ($action) {
            // 1. Quản lý user
            case 'users':
                $adminController->manageUsers();
                break;
            case 'edit_user':
                $adminController->editUser();
                break;
            case 'delete_user':
                $adminController->deleteUser();
                break;

            // 2. Quản lý danh mục (Thêm mới)
            case 'categories':
                $adminController->manageCategories();
                break;

            // 3. Duyệt khóa học (Thêm mới)
            case 'approve_courses':
                $adminController->approveCourses();
                break;

            // 4. Thống kê (Thêm mới)
            case 'statistics':
                $adminController->statistics();
                break;

            // Mặc định về Dashboard
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
