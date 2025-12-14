<?php
require_once __DIR__ . "/../models/Enrollment.php";

class EnrollmentController
{
    private $enrollmentModel;
    public function __construct()
    {
        $this->enrollmentModel = new Enrollment();
        // Nếu chưa đăng nhập → chuyển đến login
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }
    /*
    ================================
    GHI DANH KHÓA HỌC
    index.php?controller=enrollment&action=enroll&course_id=1
    ================================
    */
    public function enroll()
    {
        if (!isset($_GET['course_id'])) {
            die("Thiếu course_id!");
        }
        $courseId  = $_GET['course_id'];
        $studentId = $_SESSION['user']['id'];

        $success = $this->enrollmentModel->enrollCourse($courseId, $studentId);

        if ($success) {
            // Đăng ký thành công
            header("Location: index.php?controller=enrollment&action=my_courses&success=1");
        } else {
            // Đã đăng ký trước đó
            header("Location: index.php?controller=course&action=detail&id=$courseId&error=already_enrolled");
        }
        exit;
    }
    /*
    ================================
    XEM KHÓA HỌC ĐÃ ĐĂNG KÝ
    index.php?controller=enrollment&action=my_courses
    ================================
    */
    public function my_courses()
    {
        $studentId = $_SESSION['user']['id'];

        $myCourses = $this->enrollmentModel->getMyCourses($studentId);

        // Gọi view
        require_once "views/student/my_courses.php";
    }
    /*
    ================================
    CẬP NHẬT TIẾN ĐỘ (Progress)
    index.php?controller=enrollment&action=update_progress
    ================================
    */
    public function update_progress()
    {
        if (!isset($_POST['course_id']) || !isset($_POST['progress'])) {
            die("Thiếu dữ liệu cập nhật tiến độ!");
        }
        $rawCourseId = $_POST['course_id'];
        $rawStudentId = $_SESSION['user']['id'];
        $rawProgress = $_POST['progress'];
        $courseId  = (int)$rawCourseId;
        $studentId = (int)$rawStudentId;
        $progress  = intval($rawProgress);
        // $courseId   = $_POST['course_id'];
        // $studentId  = $_SESSION['user']['id'];
        // $progress   = intval($_POST['progress']);
        
        $this->enrollmentModel->trackProgress($progress, $courseId, $studentId);

        header("Location: index.php?controller=enrollment&action=my_courses&updated=1");
        exit;
    }
}
