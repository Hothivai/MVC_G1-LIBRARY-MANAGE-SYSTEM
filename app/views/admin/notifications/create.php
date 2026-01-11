<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-notification-create">
    <h1>Tạo Thông Báo Mới</h1>
    <form method="POST" action="/admin/notifications">
        <div class="form-group">
            <label for="title">Tiêu Đề:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="message">Nội Dung:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <div class="form-group">
            <label for="type">Loại Thông Báo:</label>
            <select id="type" name="type" required>
                <option value="info">Thông Tin</option>
                <option value="warning">Cảnh Báo</option>
                <option value="error">Lỗi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Gửi Tới Người Dùng:</label>
            <select id="user_id" name="user_id">
                <option value="">Tất Cả Người Dùng</option>
                <!-- Users will be listed here -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Gửi Thông Báo</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
