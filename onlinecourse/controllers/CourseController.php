<?php

// Import tất cả các model cần thiết từ cả 2 file
// Sử dụng __DIR__ để đảm bảo đường dẫn chính xác
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__ . '/../models/Lesson.php');
require_once(__DIR__ . '/../models/Category.php');
require_once(__DIR__ . '/../models/Enrollment.php');

class CourseController
{
    private $courseModel;
    private $lessonModel;
    private $categoryModel;
    private $enrollmentModel;

    public function __construct()
    {
        // Khởi tạo tất cả các model
        $this->courseModel = new Course();
        $this->lessonModel = new Lesson();
        $this->categoryModel = new Category();
        $this->enrollmentModel = new Enrollment();
    }

    // =================================================================
    // PHẦN 1: CHỨC NĂNG DÀNH CHO GIẢNG VIÊN (TỪ FILE 1)
    // =================================================================

    // Hien thi trang dashboard giang vien
    // (Đã đổi tên từ index -> dashboard để tránh trùng lặp với index của phần public)
    public function dashboard(): void
    {
        include 'views/instructor/dashboard.php';
    }

    // Hien thi danh sach khoa hoc cua giang vien
    public function myCourses(): void
    {
        $courses = $this->courseModel->getAllCourse(1);
        include 'views/instructor/my_courses.php';
    }

    // Hien thi form them khoa hoc
    public function create(): void
    {
        include 'views/instructor/course/create.php';
    }

    // Xu ly them khoa hoc
    public function store(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Thêm khoá học') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $instructorId = $_POST['instructorId'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $price = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level = $_POST['level'] ?? '';
            $image = $_POST['image'] ?? '';

            date_default_timezone_set('Asia/Ho_Chi_Minh'); // set timezone
            $createdAt = date('Y-m-d H-i-s');

            $isSuccess = $this->courseModel->addCourse($title, $description, $instructorId, $categoryId, $price, $durationWeeks, $level, $image, $createdAt);

            $message = $isSuccess ? 'Thêm khoá học thành công!' : 'Thêm khoá học thất bại!';

            echo $message;

            include_once 'views/instructor/course/create.php';
        }
    }

    // Xu ly xoa khoa hoc
    public function delete(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Xoá') {
            $courseId = $_POST['course_id'] ?? '';

            $isDeleted = $this->courseModel->deleteCourse($courseId);

            $message = $isDeleted ? 'Xoá khoá học thành công!' : 'Xoá khoá học thất bại!';

            echo $message;

            header('Location: index.php?controller=instructor&type=course&action=my_courses');
            exit();
        }
    }

    // Hien thi form chinh sua khoa hoc
    public function edit(): void
    {
        $id = $_POST['course_id'] ?? '';
        $course = $this->courseModel->getCourseById($id);
        include_once 'views/instructor/course/edit.php';
    }

    // Xu ly chinh sua khoa hoc
    public function update(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Sửa khoá học') {
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $instructorId = $_POST['instructorId'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $price = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level = $_POST['level'] ?? '';
            $image = $_POST['image'] ?? '';

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $updatedAt = date('Y-m-d H-i-s');

            $isSuccess = $this->courseModel->updateCourse($id, $title, $description, $instructorId, $categoryId, $price, $durationWeeks, $level, $image, $updatedAt);

            $message = $isSuccess ? 'Cập nhật khoá học thành công!' : 'Cập nhật khoá học thất bại!';

            echo $message;

            include_once 'views/instructor/course/edit.php';
        }
    }

    // Hien thi trang quan ly 1 khoa hoc cu the
    public function manage(): void
    {
        $courseId = $_POST['course_id'] ?? '';
        $course = $this->courseModel->getCourseById($courseId);
        $lessons = $this->lessonModel->getAllLessonsByCourseId($courseId);

        include_once 'views/instructor/course/manage.php';
    }

    // =================================================================
    // PHẦN 2: CHỨC NĂNG DÀNH CHO HỌC VIÊN / CÔNG KHAI (TỪ FILE 2)
    // =================================================================

    // 1. XEM DANH SÁCH KHÓA HỌC + LỌC DANH MỤC
    public function index()
    {
        // Nếu có category_id → lọc
        if (isset($_GET['category_id']) && $_GET['category_id'] !== "") {
            $categoryId = $_GET['category_id'];
            // Lấy khóa học theo danh mục
            //           $courses = $this->categoryModel->filterByCategory($categoryId);
            // Lấy thông tin danh mục (nếu cần hiển thị tiêu đề)
            //         $categoryInfo = $this->categoryModel->getCategoryById($categoryId);
        } else {
            // Lấy tất cả khóa học
            $courses = $this->courseModel->getAll();
            $categoryInfo = null;
        }
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
    public function category()
    {
        if (!isset($_GET['id'])) {
            die("Thiếu ID danh mục!");
        }
        $categoryId = $_GET['id'];

        // Lấy danh sách khóa học theo danh mục
        // $courses = $this->categoryModel->filterByCategory($categoryId);

        // if (!$courses) {
        //     $message = "Không có khóa học nào trong danh mục này.";
        // }

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
