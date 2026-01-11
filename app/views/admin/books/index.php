<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-books">
    <h1>Quản Lý Sách</h1>
    <a href="/admin/books/create" class="btn btn-primary">Thêm Sách Mới</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tiêu Đề</th>
                <th>Tác Giả</th>
                <th>Danh Mục</th>
                <th>Số Lượng</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Books will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
