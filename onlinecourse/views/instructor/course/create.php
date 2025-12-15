<!-- trang hien form them khoa hoc cua giang vien -->

<?php
include_once 'views/layouts/header.php';

//hien thi thong bao neu co
if (!empty($success) && $sucess) {
    echo '<div class="alert alert-success">Thêm khoá học thành công!</div>';
} else if (!empty($success) && !$success) {
    echo '<div class="alert alert-danger">Thêm khoá học thất bại!</div>';
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Thêm khóa học mới
            </div>

            <div class="card-body">
                <form action="index.php?controller=instructor&type=course&action=store" method="post" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Tên khóa học</label>
                        <input type="text" class="form-control"
                            placeholder="Tên khoá học" name="title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control"
                            placeholder="Mô tả" name="description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-select" name="categoryId">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá</label>
                            <input type="text" class="form-control"
                                placeholder="Giá" name="price">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời gian (tuần)</label>
                            <input type="text" class="form-control"
                                placeholder="Thời gian khoá hoc (tuần)" name="durationWeeks">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mức độ</label>
                        <select class="form-select" name="level">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh khóa học</label>
                        <input type="file"
                            class="form-control"
                            name="image"
                            accept="image/*">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="submit" class="btn btn-success" value="Thêm khoá học">
                            Thêm khóa học
                        </button>

                        <a href="index.php?controller=instructor&type=course&action=my_courses"
                            class="btn btn-secondary">
                            Xem danh sách khóa học
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>


<?php
include_once 'views/layouts/footer.php';
?>