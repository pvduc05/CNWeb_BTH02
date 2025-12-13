<?php
require_once(__DIR__ . '/../models/Course.php');
require_once(__DIR__."/../models/Category.php");
require_once(__DIR__ . '/../models/Enrollment.php');
class CourseController {
    private $courseModel;
    private $categoryModel;
    private $enrollmentModel;
    public function __construct() {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
        $this->enrollmentModel = new Enrollment();
    }
       // ============================
    // 1. XEM DANH SÁCH KHÓA HỌC + LỌC DANH MỤC
    // ============================
    public function index() {

        // Nếu có category_id → lọc
        if (isset($_GET['category_id']) && $_GET['category_id'] !== "") {

            $categoryId = $_GET['category_id'];

            // Lấy khóa học theo danh mục
            $courses = $this->categoryModel->filterByCategory($categoryId);

            // Lấy thông tin danh mục (nếu cần hiển thị tiêu đề)
            $categoryInfo = $this->categoryModel->getCategoryById($categoryId);

        } else {
            // Lấy tất cả khóa học
            $courses = $this->courseModel->getAll();
            $categoryInfo = null;
        } 
        require_once __DIR__ . "/../views/courses/index.php";
    }
     // ============================
    // 2. XEM CHI TIẾT KHÓA HỌC
    // ============================
    public function detail (): void{
        if(!isset($_GET['id'])){
            die("Thiếu ID khóa học");
        }
        $id = $_GET['id'];
        $course = $this->courseModel->getDetail($id);
        if(!$course){
            die("Không tìm thấy khóa học");
        }
         // Kiểm tra đã đăng ký chưa
        $isEnrolled = false;
        if (isset($_SESSION['user'])) {
            $studentId = $_SESSION['user']['id'];
            $isEnrolled = $this->enrollmentModel->isEnrolled($id, $studentId);
        }

        require_once __DIR__."/../views/courses/detail.php";
    }
    // ============================
    // 3. TÌM KIẾM KHÓA HỌC
    // ============================
    public function search() {
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
        $courses = $this->categoryModel->filterByCategory($categoryId);

        if (!$courses) {
            $message = "Không có khóa học nào trong danh mục này.";
        }

        // Dùng chung view hiển thị danh sách khóa học
        require_once "views/courses/index.php";
    }

    /*
    =====================================================
    5.Hiển thị 3 khóa học nổi bật nhất 
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
?>