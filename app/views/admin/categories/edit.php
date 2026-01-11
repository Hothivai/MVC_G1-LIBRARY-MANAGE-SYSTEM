<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-category-edit">
    <h1>Sửa Danh Mục</h1>
    <form method="POST" action="/admin/categories/update">
        <div class="form-group">
            <label for="name">Tên Danh Mục:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
