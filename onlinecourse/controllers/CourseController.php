<?php

require_once 'models/Course.php';
require_once 'models/Lesson.php';
require_once 'models/Category.php';
require_once 'models/User.php';

class CourseController
{
    private $courseModel;
    private $lessonModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        $this->courseModel   = new Course();
        $this->lessonModel   = new Lesson();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    //hien thi trang dashboard giang vien
    public function index(): void
    {
        include 'views/instructor/dashboard.php';
    }

    //hien thi danh sach khoa hoc
    public function myCourses(): void
    {
        $instructorId = $_SESSION['user']['id'] ?? 1;
        $courses      = $this->courseModel->getAllCourse($instructorId);
        $categories   = $this->categoryModel->getAll();

        include 'views/instructor/my_courses.php';
    }

    //hien thi form them khoa hoc
    public function create(): void
    {
        $categories = $this->categoryModel->getAll();
        include 'views/instructor/course/create.php';
    }

    //xy ly them khoa hoc
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
    public function students() : void {
        $instructorId = isset($_SESSION['user']) ? $_SESSION['user']['id'] : 1;

        $students = $this->userModel->getAllStudentsByInstructorId($instructorId);

        include_once 'views/instructor/students/list.php';
    }
}
