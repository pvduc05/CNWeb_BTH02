<?php
// Nạp Header và Sidebar của Admin
include __DIR__ . '/../../layouts/header.php';
include __DIR__ . '/../../layouts/sidebar.php';
?>

<style>
    /* CSS cho Modal nền mờ */
    .modal {
        display: none;
        /* Mặc định ẩn */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        /* Màu đen mờ */
    }

    /* CSS cho hộp thoại nội dung */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        /* Cách trên 10%, căn giữa */
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        /* Chiều rộng form */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Nút đóng X */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }

    /* CSS form trong modal */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        /* Đảm bảo padding không làm vỡ layout */
    }

    .btn-save {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-save:hover {
        background-color: #45a049;
    }

    /* Style nhẹ cho nút sửa để trông giống nút */
    .btn-edit-trigger {
        cursor: pointer;
        color: blue;
        background: none;
        border: none;
        text-decoration: underline;
        font-size: 16px;
        padding: 0;
    }
</style>

<main class="content">
    <h2>Quản lý Người dùng</h2>

    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success') echo "<p style='color: green; font-weight: bold;'>Cập nhật thành công!</p>"; ?>
        <?php if ($_GET['status'] == 'deleted') echo "<p style='color: green; font-weight: bold;'>Người dùng đã được xóa thành công.</p>"; ?>
        <?php if ($_GET['status'] == 'error') echo "<p style='color: red; font-weight: bold;'>Có lỗi xảy ra, vui lòng thử lại.</p>"; ?>
    <?php endif; ?>

    <table class="table" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background-color: #f8f9fa;">
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
                        echo isset($roles[$user['role']]) ? $roles[$user['role']] : 'Không xác định';
                        ?>
                    </td>
                    <td>
                        <button type="button" class="btn-edit-trigger"
                            onclick="openEditModal(
                                '<?php echo $user['id']; ?>', 
                                '<?php echo htmlspecialchars($user['fullname']); ?>', 
                                '<?php echo htmlspecialchars($user['email']); ?>', 
                                '<?php echo $user['role']; ?>'
                            )">
                            Sửa
                        </button>

                        |

                        <form action="index.php?controller=admin&action=delete_user" method="POST" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="btn-delete" style="color:red; border:none; background:none; cursor:pointer;" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Chỉnh sửa thông tin thành viên</h3>

        <form action="index.php?controller=admin&action=edit_user" method="POST">
            <input type="hidden" id="edit_id" name="id">

            <div class="form-group">
                <label for="edit_fullname">Tên đầy đủ:</label>
                <input type="text" id="edit_fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="edit_email">Email:</label>
                <input type="email" id="edit_email" name="email" required>
            </div>

            <div class="form-group">
                <label for="edit_role">Vai trò:</label>
                <select id="edit_role" name="role">
                    <option value="0">Học viên</option>
                    <option value="1">Giảng viên</option>
                    <option value="2">Quản trị viên</option>
                </select>
            </div>

            <div style="text-align: right;">
                <button type="button" onclick="closeModal()" style="padding: 10px; margin-right: 10px; cursor: pointer;">Hủy</button>
                <button type="submit" class="btn-save">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Hàm mở modal và điền dữ liệu
    function openEditModal(id, fullname, email, role) {
        // Gán giá trị vào các ô input trong modal
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_fullname').value = fullname;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;

        // Hiển thị modal
        document.getElementById('editModal').style.display = "block";
    }

    // Hàm đóng modal
    function closeModal() {
        document.getElementById('editModal').style.display = "none";
    }

    // Đóng modal khi click ra vùng ngoài
    window.onclick = function(event) {
        var modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php
// Nạp Footer
include __DIR__ . '/../../layouts/footer.php';
?>