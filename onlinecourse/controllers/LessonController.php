<?php

require_once 'models/Lesson.php';
require_once 'models/Course.php';
require_once 'models/Material.php';

class LessonController
{
    private $courseModel;
    private $lessonModel;
    private $materialModel;

    public function __construct()
    {
        $this->lessonModel   = new Lesson();
        $this->courseModel   = new Course();
        $this->materialModel = new Material();
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

            $message = $isSuccess ? 'Thêm bài học thành công.' : 'Thêm bài học thất bại.';

            header('Location: index.php?controller=instructor&type=course&action=manage&course_id=' . $courseId);
            exit();
        }
    }

    // hien thi form chinh sua bai hoc
    public function edit(): void
    {
        $lessonId = $_POST['lesson_id'] ?? '';

        $lesson = $this->lessonModel->getLessonById($lessonId);

        include 'views/instructor/lessons/edit.php';
    }

    // xu ly chinh sua bai hoc
    public function update(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Cập nhật bài học') {
            $lessonId    = $_POST['lesson_id'] ?? '';
            $courseId    = $_POST['course_id'] ?? '';
            $title       = $_POST['title'] ?? '';
            $content     = $_POST['content'] ?? '';
            $videoUrl    = $_POST['videoUrl'] ?? '';
            $orderLesson = $_POST['orderLesson'] ?? '';

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $updatedAt = date('Y-m-d H:i:s');

            $isSuccess = $this->lessonModel->updateLesson($lessonId, $title, $content, $videoUrl, $orderLesson, $updatedAt);

            header('Location: index.php?controller=instructor&type=course&action=manage&course_id=' . $courseId);
            exit();
        }
    }

    //xu ly logic xoa bai hoc
    public function delete(): void
    {
        if (isset($_POST['submit'])) {
            $lessonId = $_POST['lesson_id'];
            $courseId = $_POST['course_id'];

            $isSuccess = $this->lessonModel->deleteLesson($lessonId);

            header('Location: index.php?controller=instructor&type=course&action=manage&course_id=' . $courseId);
            exit();
        }
    }

    // hien thi danh sach cac tai lieu
    public function materials(): void
    {
        $lessonId = $_POST['lesson_id'] ?? $_GET['lesson_id'] ?? '';
        $courseId = $_POST['course_id'] ?? $_GET['course_id'] ?? '';

        $course = $this->courseModel->getCourseById($courseId);

        $lesson    = $this->lessonModel->getLessonById($lessonId);
        $materials = $this->materialModel->getAllMaterialsByLessonId($lessonId);

        include_once 'views/instructor/lessons/manage.php';
    }

    // hien thi trang upload tai lieu
    public function upload()
    {
        $lessonId = $_GET['lesson_id'] ?? '';

        $courseId = $_GET['course_id'];

        $lesson = $this->lessonModel->getLessonById($lessonId);
        include_once 'views/instructor/materials/upload.php';
    }

    public function uploadLogic()
    {
        if (!isset($_POST['submit'])) {
            return;
        }

        $lessonId = $_POST['lesson_id'] ?? $_GET['lesson_id'] ?? null;
        $courseId = $_POST['course_id'] ?? $_GET['course_id'] ?? null;

        if (!$lessonId || !$courseId) {
            header('Location: index.php');
            exit;
        }

        $filename = $_POST['filename'] ?? '';
        $fileType = $_POST['file_type'] ?? '';

        // thư mục ĐÃ TỒN TẠI
        $uploadDir = 'assets/uploads/materials/';

        $ext        = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $newName    = uniqid('material_', true) . '.' . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $uploadedAt = date('Y-m-d H:i:s');

            $this->materialModel->addMaterial(
                $lessonId,
                $filename,
                $newName,     // chỉ lưu tên file
                $fileType,
                $uploadedAt
            );
        }
        header('Location: index.php?controller=instructor&type=lesson&action=materials&lesson_id=' . $lessonId . '&course_id=' . $courseId);
        exit;
    }
}

?>