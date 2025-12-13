<?php

require_once 'models/Course.php';
require_once 'models/Lesson.php';

class CourseController {
    private $courseModel;   
    private $lessonModel;

    public function __construct() {
        $this->courseModel = new Course();
        $this->lessonModel = new Lesson();
    }

    //hien thi trang dashboard giang vien
    public function index() : void {
        include 'views/instructor/dashboard.php';
    }

    //hien thi danh sach khoa hoc
    public function myCourses() : void {
        $courses = $this->courseModel->getAllCourse(1);

        include 'views/instructor/my_courses.php';
    }

    //hien thi form them khoa hoc
    public function create() : void {
        include 'views/instructor/course/create.php';
    }

    //xy ly them khoa hoc
    public function store() : void {
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

    //xu ly xoa khoa hoc
    public function delete() : void {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Xoá') {
            $courseId = $_POST['course_id'] ?? '';

            $isDeleted = $this->courseModel->deleteCourse($courseId);

            $message = $isDeleted ? 'Xoá khoá học thành công!' : 'Xoá khoá học thất bại!';

            echo $message;

            header('Location: index.php?controller=instructor&type=course&action=my_courses');
            exit();
        }
    }

    //hien thi form chinh sua khoa hoc
    public function edit() : void {
        $id = $_POST['course_id'] ?? '';

        $course = $this->courseModel->getCourseById($id);

        include_once 'views/instructor/course/edit.php';
    }

    //xu ly chinh sua khoa hoc
    public function update() : void {
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

    //hien thi trang quan ly 1 khoa hoc cu the
    public function manage() : void {
        $courseId = $_POST['course_id'] ?? '';

        $course = $this->courseModel->getCourseById($courseId);
        $lessons = $this->lessonModel->getAllLessonsByCourseId($courseId);

        include_once 'views/instructor/course/manage.php';
    }
}