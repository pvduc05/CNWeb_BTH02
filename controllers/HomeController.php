<?php
// controllers/HomeController.php

class HomeController
{

    // Phương thức mặc định cho trang chủ
    public function index()
    {
        // 1. Logic lấy dữ liệu (Model)
        // Trong dự án khóa học online, đây sẽ là nơi bạn gọi Model Course
        // để lấy danh sách các khóa học nổi bật hoặc mới nhất.

        // Ví dụ: $latest_courses = $courseModel->getLatestCourses(5);

        // 2. Tải View
        // Truyền dữ liệu (nếu có) vào View và tải giao diện
        // include 'views/home/index.php';

        // Hiện tại, vì chúng ta chưa xây dựng Course Model, ta chỉ cần include View.

        include 'views/home/index.php';
    }
}
