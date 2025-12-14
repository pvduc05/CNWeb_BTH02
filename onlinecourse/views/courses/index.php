<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div class="container mt-4">

    <h3 class="mb-3">Danh sách khóa học</h3>

    <!-- Form tìm kiếm -->
    <form method="GET" action="index.php">
        <input type="hidden" name="controller" value="course">
        <input type="hidden" name="action" value="search">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Nhập tên khóa học..." name="title_course">
            <button class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
    <!-- lọc danh mục khóa học theo chủ đề -->
    <form method="GET" action="index.php" class="mb-4">
    <input type="hidden" name="controller" value="course">
    <input type="hidden" name="action" value="filter_category"> 
    <div class="input-group">
        <label class="input-group-text" for="category_id">Lọc theo Danh mục:</label>
        <select class="form-select" id="category_id" name="category_id" onchange="this.form.submit()">
            <option value="">-- Tất cả danh mục --</option>
            <?php foreach ($categories as $cat): ?>
                <?php
                    $selected = '';
                    // Kiểm tra giá trị ID nhận được từ GET
                    if (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) {
                        $selected = 'selected';
                    }
                ?>
                <option value="<?= $cat['id'] ?>" <?= $selected ?>>
                    <?= $cat['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        </div>
</form>
    <!-- kết quả tìm kiếm-->
    <?php if (isset($categoryInfo)): ?>
        <h5>Kết quả theo danh mục: <b><?= $categoryInfo['name'] ?></b></h5>
    <?php endif; ?>

    <div class="row mt-3">
        <?php foreach ($courses as $c): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="assets/uploads/courses/<?= $c['image'] ?>" class="card-img-top" height="200" style="object-fit:cover">
                    <div class="card-body">
                        <h5><?= $c['title'] ?></h5>
                        <p><?= substr($c['description'], 0, 80) ?>...</p>
                        <p><b><?= $c['price'] ?> USD</b></p>
                        <a href="index.php?controller=course&action=detail&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>