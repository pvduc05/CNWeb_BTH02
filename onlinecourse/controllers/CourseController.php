<?php

require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/Lesson.php');
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Enrollment.php');
require_once(__DIR__ . '/../models/User.php');


class CourseController
{
    private $courseModel;
    private $lessonModel;
    private $categoryModel;
    private $enrollmentModel;
    private $userModel;
    public function __construct()
    {
        // Khởi tạo tất cả các model
        $this->courseModel = new Course();
        $this->lessonModel = new Lesson();
        $this->categoryModel = new Category();
        $this->enrollmentModel = new Enrollment();
        $this->userModel = new User();
    }

    public function dashboard(): void
    {
        include 'views/instructor/dashboard.php';
    }

    // Hien thi danh sach khoa hoc cua giang vien
    public function myCourses(): void
    {
        $instructorId = $_SESSION['user']['id'] ?? 1;
        $courses      = $this->courseModel->getAllCourse($instructorId);
        $categories   = $this->categoryModel->getAll();

        include 'views/instructor/my_courses.php';
    }

    // Hien thi form them khoa hoc
    public function create(): void
    {
        $categories = $this->categoryModel->getAll();
        include 'views/instructor/course/create.php';
    }

    // Xu ly them khoa hoc
    public function store(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Thêm khoá học') {
            $title         = $_POST['title'] ?? '';
            $description   = $_POST['description'] ?? '';
            $instructorId  = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 1; // Get from session
            $categoryId    = $_POST['categoryId'] ?? '';
            $price         = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level         = $_POST['level'] ?? '';

            // Handle image upload
            $image = '';

            $uploadDir = 'assets/uploads/courses/'; // thư mục ĐÃ TỒN TẠI

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                $fileName      = $_FILES['image']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $newFileName = uniqid('course_', true) . '.' . $fileExtension;
                $targetFile  = $uploadDir . $newFileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $newFileName; // chỉ lưu tên file vào DB
                }
            }

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $createdAt = date('Y-m-d H:i:s');

            $isSuccess = $this->courseModel->addCourse(
                $title,
                $description,
                $instructorId,
                $categoryId,
                $price,
                $durationWeeks,
                $level,
                $image,
                $createdAt
            );

            $message = $isSuccess ? 'Thêm khoá học thành công' : "Thêm khoá học thất bại";

            header(
                'Location: index.php?controller=instructor&type=course&action=my_courses&message='
                    . urlencode($message)
            );
            exit;
        }
    }

    //xu ly xoa khoa hoc
    public function delete(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Xoá') {
            $courseId = $_POST['course_id'] ?? '';

            $isSuccess = $this->courseModel->deleteCourse($courseId);

            $message = $isSuccess ? 'Xoá khoá học thành công!' : 'Xoá khoá học thất bại!';

            header('Location: index.php?controller=instructor&type=course&action=my_courses&message=' . urlencode($message));
            exit();
        }
    }

    //hien thi form chinh sua khoa hoc
    public function edit(): void
    {
        $id = $_POST['course_id'] ?? '';

        $course     = $this->courseModel->getCourseById($id);
        $categories = $this->categoryModel->getAll();

        include_once 'views/instructor/course/edit.php';
    }

    //xu ly chinh sua khoa hoc
    public function update(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Sửa khoá học') {
            $id            = $_POST['id'] ?? '';
            $title         = $_POST['title'] ?? '';
            $description   = $_POST['description'] ?? '';
            $instructorId  = $_SESSION['user']['id'] ?? 1; // Get from session
            $categoryId    = $_POST['categoryId'] ?? '';
            $price         = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level         = $_POST['level'] ?? '';

            // Handle image upload
            $image = $_POST['current_image'] ?? ''; // Keep current if no new upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $uploadDir     = 'uploads/courses/';
                $fileName      = basename($_FILES['image']['name']);
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName   = uniqid() . '.' . $fileExtension;
                $targetFile    = $uploadDir . $newFileName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $newFileName;
                }
            }

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $updatedAt = date('Y-m-d H:i:s');

            $isSuccess = $this->courseModel->updateCourse($id, $title, $description, $instructorId, $categoryId, $price, $durationWeeks, $level, $image, $updatedAt);

            $message = $isSuccess ? 'Cập nhật khoá học thành công!' : 'Cập nhật khoá học thất bại!';

            header('Location: index.php?controller=instructor&type=course&action=my_courses&message=' . urlencode($message));
            exit();
        }
    }
    //hien thi trang quan ly 1 khoa hoc cu the
    public function manage(): void
    {
        $courseId = $_POST['course_id'] ?? $_GET['course_id'] ?? '';

        $course  = $this->courseModel->getCourseById($courseId);
        $lessons = $this->lessonModel->getAllLessonsByCourseId($courseId);

        include_once 'views/instructor/course/manage.php';
    }
    //hien thi trang danh sach hoc vien da dang ky 1 khoa hoc
    public function students(): void
    {
        $instructorId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 1;

        $students = $this->userModel->getAllStudentsByInstructorId($instructorId);

        include_once 'views/instructor/students/list.php';
    }

    // 1. XEM DANH SÁCH KHÓA HỌC + LỌC DANH MỤC
    public function index()
    {
        // Nếu có category_id → lọc
        if (isset($_GET['category_id']) && $_GET['category_id'] !== "") {
            $categoryId = $_GET['category_id'];
            // Lấy khóa học theo danh mục
            // $courses = $this->categoryModel->filterByCategory($categoryId);
            // // Lấy thông tin danh mục (nếu cần hiển thị tiêu đề)
            // $categoryInfo = $this->categoryModel->getCategoryById($categoryId);
        } else {
            // Lấy tất cả khóa học
            $courses = $this->courseModel->getAll();
            $categoryInfo = null;
        }
        $categoriesStmt = $this->categoryModel->getAll();
        $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . "/../views/courses/index.php";
    }

    // 2. XEM CHI TIẾT KHÓA HỌC
    public function detail(): void
    {
        if (!isset($_GET['id'])) {
            die("Thiếu ID khóa học");
        }
        $id = $_GET['id'];
        $course = $this->courseModel->getDetail($id);
        if (!$course) {
            die("Không tìm thấy khóa học");
        }

        // Kiểm tra đã đăng ký chưa
        $isEnrolled = false;
        if (isset($_SESSION['user'])) {
            $studentId = $_SESSION['user']['id'];
            $isEnrolled = $this->enrollmentModel->isEnrolled($id, $studentId);
        }

        require_once __DIR__ . "/../views/courses/detail.php";
    }

    // 3. TÌM KIẾM KHÓA HỌC
    public function search()
    {
        // Lấy keyword an toàn
        $keyword = $_GET['title_course'] ?? '';
        if (trim($keyword) == '') {
            $course_search = [];
        } else {
            // Gọi model để search
            $course_search = $this->courseModel->search($keyword);
        }

        // Load giao diện
        require_once __DIR__ . "/../views/courses/search.php";
    }

    /*
    =====================================================
    LỌC THEO DANH MỤC
    URL: index.php?controller=course&action=category&id=2
    =====================================================
    */
    public function filter_category()
    {
        $categoryId = $_GET['category_id'] ?? ''; // Lấy ID danh mục từ form GET

        $categoryInfo = null;

        // 1. Nếu có ID danh mục được chọn
        if (!empty($categoryId) && is_numeric($categoryId)) {
            // Lấy thông tin chi tiết danh mục (sử dụng getById)
            $categoryInfo = $this->categoryModel->getById($categoryId);

            // Hàm getById trong Category.php của bạn trả về row hoặc null
            if ($categoryInfo) {
                // Nếu tìm thấy, giữ nguyên $categoryId để lọc
                $categoryId = $categoryInfo['id'];
            }
        }

        // 2. Lấy danh sách khóa học theo ID (hoặc tất cả nếu ID rỗng)
        $courses = $this->courseModel->filterByCategoryId($categoryId);

        // 3. Lấy lại danh sách TẤT CẢ danh mục để đổ vào form SELECT
        $categoriesStmt = $this->categoryModel->getAll();
        $categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

        // 4. Load View
        require_once "views/courses/index.php";
    }
    public function category()
    {
        if (!isset($_GET['id'])) {
            die("Thiếu ID danh mục!");
        }
        $categoryId = $_GET['id'];

        // Lấy danh sách khóa học theo danh mục
        $courses = $this->categoryModel->filterByCategory($categoryId);

        if (!$courses) {
            $message = "Không có khóa học nào trong danh mục này.";
        }

        // Dùng chung view hiển thị danh sách khóa học
        require_once "views/courses/index.php";
    }

    /*
    =====================================================
    5. Hiển thị 3 khóa học nổi bật nhất 
    =====================================================
    */
    public function indexThree()
    {
        $message = "";
        $courses_home = $this->courseModel->getThree();
        if (!$courses_home) {
            $message = "Không có khóa học nào trong danh mục này.";
        }
        require_once "views/home/index.php";
    }
}
