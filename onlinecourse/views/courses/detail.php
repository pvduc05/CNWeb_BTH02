<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h2><?php echo $course['title']; ?></h2>

    <div class="row mt-4">
        <div class="col-md-5">
            <img src="assets/uploads/courses/<?php echo $course['image']; ?>" 
                 class="img-fluid rounded shadow-sm">
        </div>

        <div class="col-md-7">
            <p><strong>Mô tả:</strong> <?php echo $course['description']; ?></p>

            <p><strong>Giảng viên:</strong> <?php echo $course['instructor_name']; ?></p>

            <p><strong>Danh mục:</strong> <?php echo $course['category_name']; ?></p>

            <p><strong>Thời lượng:</strong> <?php echo $course['duration_weeks']; ?> tuần</p>

            <p><strong>Cấp độ:</strong> <?php echo $course['level']; ?></p>

            <p><strong>Giá:</strong> 
                <span class="text-danger fw-bold">
                    <?php echo number_format($course['price']); ?> USD 
                </span>
            </p>

            <a href="#" class="btn btn-success">Đăng ký khóa học</a>
        </div>
    </div> 

</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
