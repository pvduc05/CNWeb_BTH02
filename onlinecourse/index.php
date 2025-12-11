<?php

require_once './controllers/CourseController.php';

$courseController = new CourseController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $courseController->index(); // hien thi danh sach khoa hoc
        break;
    case 'create':
        $courseController->create(); // hien thi form them khoa hoc
        break;
    case 'store':
        $courseController->store(); // xu ly them khoa hoc
        break;
    case 'delete':
        $courseController->delete(); // xu ly xoa khoa hoc
        break;
    case 'edit':
        $courseController->edit(); // hien thi form sua khoa hoc
        break;
    case 'update':
        $courseController->update(); // xu ly sua khoa hoc
        break;
    default:
        echo 'Hanh dong khong hop le.';
        break;
}