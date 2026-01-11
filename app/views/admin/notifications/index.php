<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-notifications">
    <h1>Quản Lý Thông Báo</h1>
    <a href="/admin/notifications/create" class="btn btn-primary">Tạo Thông Báo Mới</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Loại</th>
                <th>Ngày Tạo</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Notifications will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
