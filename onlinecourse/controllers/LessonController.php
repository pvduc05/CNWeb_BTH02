<?php

require_once 'models/Lesson.php';
require_once 'models/Course.php';

class LessonController
{
    private $courseModel;
    private $lessonModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
    }

    // hien thi danh sach bai hoc cua 1 khoa hoc (la trang manage cua course)
    public function index(): void
    {
        $courseId = $_POST['course_id'] ?? '';

        $course  = $this->courseModel->getCourseById($courseId);
        $lessons = $this->lessonModel->getAllLessonsByCourseId($courseId);

        include 'views/instructor/course/manage.php';
    }

    // hien thi form them bai hoc
    public function create(): void
    {
        include 'views/instructor/lessons/create.php';
    }

    // xu ly them bai hoc
    public function store(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Thêm bài học') {
            $courseId    = $_POST['course_id'] ?? '';
            $title       = $_POST['title'] ?? '';
            $content     = $_POST['content'] ?? '';
            $videoUrl    = $_POST['videoUrl'] ?? '';
            $orderLesson = $_POST['orderLesson'] ?? '';

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $createdAt = date('Y-m-d H:i:s');

            $isSuccess = $this->lessonModel->addLesson($courseId, $title, $content, $videoUrl, $orderLesson, $createdAt);

            // $message = $isSuccess ? 'Thêm bài học thành công.' : 'Thêm bài học thất bại.';

            // echo $message;

            header('Location: index.php?controller=instructor&type=course&action=manage');
            exit();
        }
    }
}
