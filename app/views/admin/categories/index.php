<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-categories">
    <h1>Quản Lý Danh Mục</h1>
    <a href="/admin/categories/create" class="btn btn-primary">Thêm Danh Mục</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Danh Mục</th>
                <th>Mô Tả</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <!-- Categories will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
