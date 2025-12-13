<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Course</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">OnlineCourse</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php?controller=course&action=index">Khóa học</a></li>

                <?php if (!isset($_SESSION['user'])): ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=auth&action=login">Đăng nhập</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=auth&action=register">Đăng ký</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=enrollment&action=my_courses">Khóa học của tôi</a></li>
                    <li class="nav-item"><a class="nav-link text-warning" href="#">Xin chào, <?= $_SESSION['user']['fullname'] ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=auth&action=logout">Đăng xuất</a></li>
                <?php endif; ?>

            </ul>
        </div>

    </div>
</nav>
