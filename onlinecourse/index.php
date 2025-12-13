<!-- Trang dieu huong all -->

<?php

// require_once './controllers/CourseController.php';

// $courseController = new CourseController();

// $action = $_GET['action'] ?? 'index';

// switch ($action) {
//     case 'index':
//         $courseController->index(); // hien thi danh sach khoa hoc
//         break;
//     case 'create':
//         $courseController->create(); // hien thi form them khoa hoc
//         break;
//     case 'store':
//         $courseController->store(); // xu ly them khoa hoc
//         break;
//     case 'delete':
//         $courseController->delete(); // xu ly xoa khoa hoc
//         break;
//     case 'edit':
//         $courseController->edit(); // hien thi form sua khoa hoc
//         break;
//     case 'update':
//         $courseController->update(); // xu ly sua khoa hoc
//         break;
//     default:
//         echo 'Hanh dong khong hop le.';
//         break;
// }

?>

<?php
session_start(); // Bắt buộc phải có để dùng $_SESSION

// Router đơn giản
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($controller) {
    case 'home':
        // include 'controllers/HomeController.php';
        // $homeController = new HomeController();
        // $homeController->index();
        break;

    case 'auth':
        // include 'controllers/AuthController.php';
        // $auth = new AuthController();
        // if ($action == 'login') $auth->login();
        // elseif ($action == 'register') $auth->register();
        // elseif ($action == 'logout') $auth->logout();
        break;

    case 'student':
        // Kiểm tra quyền trước khi vào Controller này
        checkRole(0);
        // include 'controllers/StudentController.php'; ...
        include 'views/student/dashboard.php'; // Tạm thời hiển thị view
        break;

//--------------------------Giang vien Route Start----------------------------//
    case 'instructor':
        // checkRole(1);
        $type = $_GET['type'] ?? ''; //dang thuc hien thao tac voi doi tuong nao

        //tuong tac voi doi tuong nao thi tao controller cua doi tuong ay
        if ($type === 'course') {
            require_once 'controllers/CourseController.php';
            $dynamicController = new CourseController();
        } else if ($type === 'lesson') {
            require_once 'controllers/LessonController.php';
            $dynamicController = new LessonController();
        }

        switch ($action) {
            case 'index':
                $dynamicController->index();
                break;
            case 'my_courses':
                $dynamicController->myCourses();
                break;
            case 'create':
                $dynamicController->create();
                break;
            case 'store':
                $dynamicController->store();
                break;
            case 'delete':
                $dynamicController->delete();
                break;
            case 'edit':
                $dynamicController->edit();
                break;
            case 'update':
                $dynamicController->update();
                break;
            case 'manage':
                $dynamicController->manage();
                break;
            default:
                echo 'Hanh dong khong hop le.';
                break;
        }
        break;
//--------------------------Giang vien Route End----------------------------//

    case 'admin':
        // checkRole(2);
        // require_once 'controllers/AdminController.php';
        // $adminController = new AdminController();

        // switch ($action) {
        //     // 1. Quản lý user
        //     case 'users':
        //         $adminController->manageUsers();
        //         break;
        //     case 'edit_user':
        //         $adminController->editUser();
        //         break;
        //     case 'delete_user':
        //         $adminController->deleteUser();
        //         break;

        //     // 2. Quản lý danh mục (Thêm mới)
        //     case 'categories':
        //         $adminController->manageCategories();
        //         break;

        //     // 3. Duyệt khóa học (Thêm mới)
        //     case 'approve_courses':
        //         $adminController->approveCourses();
        //         break;

        //     // 4. Thống kê (Thêm mới)
        //     case 'statistics':
        //         $adminController->statistics();
        //         break;

        //     // Mặc định về Dashboard
        //     default:
        //         $adminController->dashboard();
        //         break;
        // }
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