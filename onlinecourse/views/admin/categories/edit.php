<?php include 'views/layouts/header.php'; ?>

<div class="main-content">
    <h2>Sửa Danh mục: <?php echo htmlspecialchars($category['name']); ?></h2>

    <form action="index.php?controller=admin&action=edit_category&id=<?php echo $category['id']; ?>" method="POST">
        <div style="margin-bottom: 10px;">
            <label>Tên danh mục:</label><br>
            <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required style="width: 300px; padding: 5px;">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Mô tả:</label><br>
            <textarea name="description" rows="4" style="width: 300px; padding: 5px;"><?php echo htmlspecialchars($category['description']); ?></textarea>
        </div>

        <button type="submit" style="padding: 5px 15px;">Cập nhật</button>
        <a href="index.php?controller=admin&action=categories">Hủy</a>
    </form>
</div>

<?php include 'views/layouts/footer.php'; ?>