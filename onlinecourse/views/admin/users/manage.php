<?php
// Nạp Header và Sidebar của Admin
include __DIR__ . '/../../layouts/header.php';
include __DIR__ . '/../../layouts/sidebar.php';
?>

<main class="content">
    <h2>Quản lý Người dùng</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
        <p style="color: green;">Người dùng đã được xóa thành công.</p>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Tên đầy đủ</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                    <td>
                        <?php
                        // Hiển thị tên vai trò thay vì số
                        $roles = [0 => 'Học viên', 1 => 'Giảng viên', 2 => 'Quản trị viên'];
                        echo $roles[$user['role']];
                        ?>
                    </td>
                    <td>
                        <a href="/admin/user/edit?id=<?php echo $user['id']; ?>" class="btn-edit">Sửa</a>

                        <form action="/admin/user/delete" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
// Nạp Footer
include __DIR__ . '/../../layouts/footer.php';
?>