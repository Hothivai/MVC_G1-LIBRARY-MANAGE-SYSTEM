<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1 bg-light">
        <nav class="navbar navbar-light bg-white px-4 border-bottom">
            <span class="navbar-brand fw-bold">Edit Book</span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="index.php?action=admin_book_store" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Book Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter book title" value="<?= htmlspecialchars($book['title'] ?? '') ?>">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                                <input type="text" name="author" class="form-control" required placeholder="Enter author name" value="<?= htmlspecialchars($book['author'] ?? '') ?>">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-select">
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>" <?= ($book['category_id'] == $cat['category_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['category_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">ISBN</label>
                                <input type="text" name="isbn" class="form-control" placeholder="e.g. 978-3-16-148410-0" value="<?= htmlspecialchars($book['isbn'] ?? '') ?>">
                            </div>


                            <div class="col-md-6">
                                <label class="form-label fw-bold">Publisher</label>
                                <input type="text" name="publisher" class="form-control" value="<?= htmlspecialchars($book['publisher'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Publication Year</label>
                                <input type="number" name="published_year" class="form-control" value="<?= $book['published_year'] ?? date('Y') ?>">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($book['description'] ?? '') ?></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Cover Image</label>
                                <?php if (!empty($book['cover_image']) || !empty($book['image_url'])): ?>
                                    <?php $currentImage = $book['cover_image'] ?? $book['image_url'] ?? ''; ?>
                                    <div class="mb-2">
                                        <img src="/public/<?= htmlspecialchars($currentImage) ?>" alt="Current cover" style="max-height: 150px; border: 1px solid #ddd; border-radius: 4px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="cover_image" class="form-control">
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="index.php?action=admin_books_index" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-check-lg"></i> Update Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>