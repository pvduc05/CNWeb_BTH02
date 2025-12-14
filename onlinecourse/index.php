<?php
session_start(); // Bắt buộc phải có để dùng $_SESSION

// =================================================================================
// 1. CẤU HÌNH ROUTER CƠ BẢN
// =================================================================================

// Lấy controller & action từ URL
$controller = $_GET['controller'] ?? 'home';
$action     = $_GET['action']     ?? 'index';

// =================================================================================
// 2. XỬ LÝ ROUTING (ĐIỀU HƯỚNG)
// =================================================================================

switch ($controller) {

    // -------------------------------------------------------------------------
    // CASE: AUTH (Đăng nhập, Đăng ký, Đăng xuất) - Từ File 1
    // -------------------------------------------------------------------------
    case 'auth':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        if ($action == 'login') $auth->login();
        elseif ($action == 'register') $auth->register();
        elseif ($action == 'logout') $auth->logout();
        break;

    // -------------------------------------------------------------------------
    // CASE: STUDENT (Học viên) - Từ File 1 & 3
    // -------------------------------------------------------------------------
    // -------------------------------------------------------------------------
    // CASE: STUDENT (Học viên)
    // -------------------------------------------------------------------------
    case 'student':
        checkRole(0); // Bắt buộc là học viên

        switch ($action) {
            // 1. Mặc định vào Dashboard
            case 'index':
            case 'dashboard':
                include 'views/student/dashboard.php';
                break;

            // 2. Xem danh sách khóa học (Tận dụng EnrollmentController đã có)
            case 'my_courses':
                require_once 'controllers/EnrollmentController.php';
                $enrollmentCtrl = new EnrollmentController();
                $enrollmentCtrl->my_courses();
                // Hàm này trong EnrollmentController đã include view 'views/student/my_courses.php'
                break;

            // 3. Vào học / Xem tiến độ (Xử lý logic trực tiếp tại đây vì không tạo file mới)
            case 'course_progress':
                if (!isset($_GET['course_id'])) {
                    die("Thiếu ID khóa học");
                }

                // Import các Model cần thiết
                require_once 'models/Enrollment.php';
                require_once 'models/Course.php';
                require_once 'models/Lesson.php';

                // Khởi tạo Model
                $enrollModel = new Enrollment();
                $courseModel = new Course();
                $lessonModel = new Lesson();

                $courseId  = $_GET['course_id'];
                $studentId = $_SESSION['user']['id'];

                // a. Kiểm tra xem đã đăng ký chưa
                $enrollment = $enrollModel->isEnrolled($courseId, $studentId);
                if (!$enrollment) {
                    die("Bạn chưa đăng ký khóa học này!");
                }
                $progress = $enrollment['progress']; // Lấy % tiến độ

                // b. Lấy thông tin chi tiết khóa học
                // Lưu ý: Đảm bảo model Course có hàm getCourseById hoặc getDetail
                $course = $courseModel->getCourseById($courseId);

                // c. Lấy danh sách bài học
                $lessons = $lessonModel->getAllLessonsByCourseId($courseId);

                // d. Hiển thị View
                include 'views/student/course_progress.php';
                break;

            default:
                include 'views/student/dashboard.php';
                break;
        }
        break;

    // -------------------------------------------------------------------------
    // CASE: ENROLLMENT (Xử lý các hành động POST form)
    // -------------------------------------------------------------------------
    // Case này cần thiết vì trong view my_courses.php và course_progress.php 
    // bạn đang để form action="index.php?controller=enrollment..."
    case 'enrollment':
        checkRole(0);
        require_once 'controllers/EnrollmentController.php';
        $enrollmentCtrl = new EnrollmentController();

        if ($action == 'enroll') {
            $enrollmentCtrl->enroll();
        } elseif ($action == 'my_courses') {
            $enrollmentCtrl->my_courses();
        } elseif ($action == 'update_progress') {
            $enrollmentCtrl->update_progress();
        }
        break;
    // -------------------------------------------------------------------------
    // CASE: INSTRUCTOR (Giảng viên) - Lấy logic chi tiết từ File 3
    // -------------------------------------------------------------------------
    case 'instructor':
        // Kiểm tra quyền (Role 1: Giảng viên)
        // checkRole(1); // Bạn có thể bỏ comment nếu muốn bắt buộc check quyền ngay

        $type = $_GET['type'] ?? ''; // đang thực hiện thao tác với đối tượng nào (course hay lesson)

        // Tương tác với đối tượng nào thì tạo controller của đối tượng ấy
        if ($type === 'course') {
            require_once 'controllers/CourseController.php';
            $dynamicController = new CourseController();
        } else if ($type === 'lesson') {
            require_once 'controllers/LessonController.php';
            $dynamicController = new LessonController();
        } else {
            // Mặc định nếu không có type thì hiển thị dashboard (Từ File 1)
            include 'views/instructor/dashboard.php';
            break;
        }

        // Switch case xử lý các hành động CRUD của giảng viên
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
                echo 'Hành động không hợp lệ.';
                break;
        }
        break;

    // -------------------------------------------------------------------------
    // CASE: ADMIN (Quản trị viên) - Lấy logic chi tiết từ File 1
    // -------------------------------------------------------------------------
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

            // 3. Các chức năng khác
            case 'approve_courses':     // Duyệt khóa học
                $adminController->approveCourses();
                break;
            case 'statistics':          // Thống kê
                $adminController->statistics();
                break;

            // Mặc định: Về Dashboard Admin
            case 'dashboard':
            default:
                $adminController->dashboard();
                break;
        }
        break;

    // -------------------------------------------------------------------------
    // DEFAULT: DYNAMIC ROUTING (Xử lý các Controller khác) - Từ File 2
    // -------------------------------------------------------------------------
    // Nếu không rơi vào các case đặc biệt (admin, instructor...), 
    // hệ thống sẽ tự động tìm controller dựa trên tên file.
    default:
        // Tạo tên controller file & class
        $controllerName = ucfirst($controller) . "Controller";
        $controllerFile = __DIR__ . "/controllers/" . $controllerName . ".php";

        // Kiểm tra file controller tồn tại hay không
        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Kiểm tra class có tồn tại không
            if (class_exists($controllerName)) {
                $controllerObj = new $controllerName();

                // Kiểm tra action có tồn tại không
                if (method_exists($controllerObj, $action)) {
                    $controllerObj->$action();
                } else {
                    die("Action '$action' không tồn tại trong '$controllerName'");
                }
            } else {
                die("Class '$controllerName' không tồn tại trong file $controllerFile");
            }
        } else {
            // Nếu không tìm thấy Controller nào cả -> 404
            if ($controller === 'home') {
                // Fallback đặc biệt cho Home nếu chưa có HomeController
                echo "Trang chủ (Chưa có HomeController)";
            } else {
                echo "404 Not Found - Controller '$controllerName' không tồn tại!";
            }
        }
        break;
}

// =================================================================================
// 3. HÀM HỖ TRỢ
// =================================================================================

// Hàm kiểm tra quyền đơn giản (Từ File 1 & 3)
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
