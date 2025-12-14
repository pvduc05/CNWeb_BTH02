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
        $this->lessonModel = new Lesson();
        $this->courseModel = new Course();
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

            echo $message;

            header('Location: index.php?controller=instructor&type=course&action=manage&course_id=' . $courseId);
            exit();
        }
    }

    // hien thi form chinh sua bai hoc
    public function edit(): void
    {
        $lessonId = $_POST['lesson_id'] ?? '';
        $courseId = $_POST['course_id'] ?? '';

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

    // xu ly upload tai lieu
    public function uploadMaterial(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Đăng tải') {
            $lessonId = $_POST['lesson_id'] ?? '';
            $courseId = $_POST['course_id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';

            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/materials/';

                // Create directory if not exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalFileName = basename($_FILES['file']['name']);
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $targetFile = $uploadDir . $newFileName;

                // Check file size (50MB max)
                if ($_FILES['file']['size'] > 50 * 1024 * 1024) {
                    $message = 'File quá lớn! Tối đa 50MB.';
                    header('Location: index.php?controller=instructor&type=lesson&action=materials&lesson_id=' . $lessonId . '&course_id=' . $courseId . '&message=' . urlencode($message));
                    exit();
                }

                // Allowed file types
                $allowedTypes = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'txt', 'zip', 'rar'];
                if (!in_array(strtolower($fileExtension), $allowedTypes)) {
                    $message = 'Loại file không được hỗ trợ!';
                    header('Location: index.php?controller=instructor&type=lesson&action=manageMaterials&lesson_id=' . $lessonId . '&course_id=' . $courseId . '&message=' . urlencode($message));
                    exit();
                }

                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $uploadedAt = date('Y-m-d H:i:s');

                    $isSuccess = $this->materialModel->addMaterial($lessonId, $title, $description, $originalFileName, $newFileName, $fileExtension, $uploadedAt);

                    $message = $isSuccess ? 'Upload tài liệu thành công!' : 'Upload tài liệu thất bại!';
                } else {
                    $message = 'Upload file thất bại!';
                }
            } else {
                $message = 'Vui lòng chọn file!';
            }

            header('Location: index.php?controller=instructor&type=lesson&action=upload_material&lesson_id=' . $lessonId . '&course_id=' . $courseId . '&message=' . urlencode($message));
            exit();
        }
    }

    // xu ly xoa tai lieu
    public function deleteMaterial(): void
    {
        if (isset($_POST['submit']) && $_POST['submit'] === 'Xóa') {
            $materialId = $_POST['material_id'] ?? '';
            $lessonId = $_POST['lesson_id'] ?? '';
            $courseId = $_POST['course_id'] ?? '';

            // Get material info to delete file
            $materials = $this->materialModel->getAllMaterialsByLessonId($lessonId);
            $material = array_filter($materials, function($m) use ($materialId) {
                return $m['id'] == $materialId;
            });

            if (!empty($material)) {
                $material = reset($material);
                $filePath = 'uploads/materials/' . $material['file_path'];

                // Delete file from server
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                // Delete from database
                $isSuccess = $this->materialModel->deleteMaterial($materialId);
                $message = $isSuccess ? 'Xóa tài liệu thành công!' : 'Xóa tài liệu thất bại!';
            } else {
                $message = 'Tài liệu không tồn tại!';
            }

            header('Location: index.php?controller=instructor&type=lesson&action=delete_materials&lesson_id=' . $lessonId . '&course_id=' . $courseId . '&message=' . urlencode($message));
            exit();
        }
    }

    // hien thi trang upload tai lieu cho bai hoc
    public function materials(): void
    {
        $lessonId = $_POST['lesson_id'] ?? $_GET['lesson_id'] ?? '';
        $courseId = $_POST['course_id'] ?? $_GET['course_id'] ?? '';

        if (!$lessonId) {
            header('Location: index.php?controller=instructor&type=course&action=manage&course_id=' . $courseId);
            exit();
        }

        $lesson = $this->lessonModel->getLessonById($lessonId);
        $course = $this->courseModel->getCourseById($courseId);

        $materials     = $this->materialModel->getAllMaterialsByLessonId($lessonId);
        include 'views/instructor/lessons/manage.php';
    }
}
