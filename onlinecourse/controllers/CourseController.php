<?php

require_once 'models/Course.php';

class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    //hien thi danh sach khoa hoc
    public function index() {
        $courses = $this->courseModel->getAllCourse();

        if (count($courses) === 0) {
            echo "<p>Không có khoá học nào!</p>";
        }

        include 'views/instructor/course/manage.php';
    }

    //hien thi form them khoa hoc
    public function create() {
        include 'views/instructor/course/create.php';
    }

    //xy ly them khoa hoc
    public function store() {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Thêm khoá học') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $instructorId = $_POST['instructorId'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $price = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level = $_POST['level'] ?? '';
            $image = $_POST['image'] ?? '';

            $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
            $createdAt = date('Y-m-d H-i-s');

            $isSuccess = $this->courseModel->addCourse($title, $description, $instructorId, $categoryId, $price, $durationWeeks, $level, $image, $createdAt);

            if ($isSuccess) {
                echo 'Thêm khoá học thành công!';
            } else {
                echo 'Thêm khoá học thất bại!';
            }

            include 'views/instructor/course/create.php';
        }
    }

    //xu
    public function delete() {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Xoá') {
            $courseId = $_POST['course_id'] ?? '';

            $isDeleted = $this->courseModel->deleteCourse($courseId);

            if ($isDeleted) {
                echo 'Xoá khoá học thành công!';
            } else {
                echo 'Xoá khoá học thất bại!';
            }

            header('Location: index.php?action=index');
            exit();
        }
    }

    //hien thi form chinh sua khoa hoc
    public function edit() {
        $id = $_POST['course_id'] ?? '';

        $course = $this->courseModel->getCourseById($id);

        include 'views/instructor/course/edit.php';
    }

    //xu ly chinh sua khoa hoc
    public function update() {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Thêm khoá học') {
            $id = $_POST['id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $instructorId = $_POST['instructorId'] ?? '';
            $categoryId = $_POST['categoryId'] ?? '';
            $price = $_POST['price'] ?? '';
            $durationWeeks = $_POST['durationWeeks'] ?? '';
            $level = $_POST['level'] ?? '';
            $image = $_POST['image'] ?? '';

            $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
            $updatedAt = date('Y-m-d H-i-s');

            $isSuccess = $this->courseModel->updateCourse($id, $title, $description, $instructorId, $categoryId, $price, $durationWeeks, $level, $image, $updatedAt);

            if ($isSuccess) {
                echo 'Chỉnh sửa khoá học thành công!';
            } else {
                echo 'Chỉnh sửa khoá học thất bại!';
            }

            include 'views/instructor/course/edit.php';
        }
    }
}