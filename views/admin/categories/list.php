<?php include 'views/layouts/header.php'; ?>
<div class="main-content">
    <h2>Quản lý Danh mục Khóa học</h2>
    <a href="index.php?controller=admin&action=create_category" class="btn btn-primary" style="margin-bottom: 15px;">+ Thêm mới</a>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f2f2f2;">
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $cat): ?>
                <tr>
                    <td><?php echo $cat['id']; ?></td>
                    <td><strong><?php echo htmlspecialchars($cat['name']); ?></strong></td>
                    <td><?php echo htmlspecialchars($cat['description']); ?></td>
                    <td><?php echo $cat['created_at']; ?></td>
                    <td>
                        <a href="index.php?controller=admin&action=edit_category&id=<?php echo $cat['id']; ?>">Sửa</a>
                        |
                        <form action="index.php?controller=admin&action=delete_category" method="POST" style="display:inline;" onsubmit="return confirm('Xóa danh mục này?');">
                            <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                            <button type="submit" style="color:red; border:none; background:none; cursor:pointer;">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'views/layouts/footer.php';
?>