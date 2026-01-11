<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-user-edit">
    <h1>Chỉnh Sửa Người Dùng</h1>
    <form method="POST" action="/admin/users/update">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="role">Vai Trò:</label>
            <select id="role" name="role" required>
                <option value="user">Người Dùng</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Trạng Thái:</label>
            <select id="status" name="status" required>
                <option value="active">Hoạt Động</option>
                <option value="inactive">Không Hoạt Động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
