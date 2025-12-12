<?php
include_once(__DIR__ . '/../models/Course.php');
include_once(__DIR__ . '/../models/Category.php');

class HomeController {
    private $courseModel;
    private $categoryModel;

    public function __construct() {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
    }

    public function index() {
        $courses = $this->courseModel->getAll();
        $categories = $this->categoryModel->getAll();

        $data = [
            'courses' => $courses,
            'categories' => $categories
        ];

        $this->renderView("home/index", $data);
    }

    private function renderView($view, $data = []) {
        extract($data);
        include(__DIR__."/../views/layouts/header.php");
        include(__DIR__."/../views/".$view.".php");
        include(__DIR__."/../views/layouts/footer.php");
    }
}
