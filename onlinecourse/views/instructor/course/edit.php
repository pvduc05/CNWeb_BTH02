<!-- trang chinh sua khoa hoc cua giang vien -->

<?php
include_once 'views/layouts/header.php';

//hien thi thong bao neu co
if (! empty($success) && $sucess) {
    echo '<div class="alert alert-success">Sửa khoá học thành công!</div>';
} else if (! empty($success) && ! $success) {
    echo '<div class="alert alert-danger">Sửa khoá học thất bại!</div>';
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Chỉnh sửa khóa học
            </div>

            <div class="card-body">
                <form action="index.php?controller=instructor&type=course&action=update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($course['id']); ?>">
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($course['image']); ?>">

                    <div class="mb-3">
                        <label class="form-label">Tên khóa học</label>
                        <input type="text" class="form-control"
                            placeholder="Tên khoá học" name="title" value="<?php echo htmlspecialchars($course['title']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control"
                            placeholder="Mô tả" name="description"><?php echo htmlspecialchars($course['description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-select" name="categoryId">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['id']) ?>" <?php if ($category['id'] == $course['category_id']) {
                                                                                                    echo 'selected';
                                                                                                } ?>>
                                    <?php echo htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giá</label>
                            <input type="text" class="form-control"
                                placeholder="Giá" name="price" value="<?php echo htmlspecialchars($course['price']) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Thời gian (tuần)</label>
                            <input type="text" class="form-control"
                                placeholder="Thời gian khoá hoc (tuần)" name="durationWeeks" value="<?php echo htmlspecialchars($course['duration_weeks']) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mức độ</label>
                        <select class="form-select" name="level">
                            <option
                                value="Beginner" <?php if ($course['level'] == 'Beginner') {
                                                        echo 'selected';
                                                    } ?>>Beginner</option>
                            <option value="Intermediate" <?php if ($course['level'] == 'Intermediate') {
                                                                echo 'selected';
                                                            } ?>>Intermediate</option>
                            <option value="Advanced" <?php if ($course['level'] == 'Advanced') {
                                                            echo 'selected';
                                                        } ?>>Advanced</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh khóa học</label>
                        <?php if ($course['image']): ?>
                            <div class="mb-2">
                                <img src="uploads/courses/<?php echo htmlspecialchars($course['image']); ?>" alt="Current Image" style="max-width: 200px;">
                            </div>
                        <?php endif; ?>
                        <input type="file"
                            class="form-control"
                            name="image"
                            accept="image/*">
                        <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="submit" class="btn btn-success" value="Sửa khoá học">
                            Cập nhật khóa học
                        </button>

                        <a href="index.php?controller=instructor&type=course&action=my_courses"
                            class="btn btn-secondary">
                            Quay lại danh sách
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