<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-book-edit">
    <h1>Edit book information</h1>
    <form method="POST" action="/admin/books/update" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" required>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn">
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select id="category_id" name="category_id" required>
                <!-- Categories will be listed here -->
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
