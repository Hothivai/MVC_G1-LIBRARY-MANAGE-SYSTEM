<?php include APP_PATH . '/views/layouts/header.php'; ?>

<section class="admin-book-create">
    <h1>Add New Book</h1>

    <form method="POST"
          action="index.php?action=admin_book_store"
          enctype="multipart/form-data">

        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>

        <div class="form-group">
            <label>Author:</label>
            <input type="text" name="author" required>
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input type="text" name="isbn">
        </div>

        <div class="form-group">
            <label>Category:</label>
            <select name="category_id" required>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id'] ?>">
                            <?= $category['category_name'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>

        <div class="form-group">
            <label>Quantity:</label>
            <input type="number" name="quantity" required>
        </div>

        <div class="form-group">
            <label>Cover Image:</label>
            <input type="file" name="cover_image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">
            Add Book
        </button>
    </form>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
