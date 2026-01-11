<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-category-create">
    <h1>Thêm Danh Mục Mới</h1>
    <form method="POST" action="/admin/categories">
        <div class="form-group">
            <label for="name">Tên Danh Mục:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Danh Mục</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
