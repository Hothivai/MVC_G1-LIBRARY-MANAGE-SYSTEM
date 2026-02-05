<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1 bg-light">
        <nav class="navbar navbar-light bg-white px-4 border-bottom">
            <span class="navbar-brand fw-bold">Add New Book</span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <?php if (isset($flash_error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($flash_error) ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($flash_success)): ?>
                        <div class="alert alert-success" role="alert">
                            <?= htmlspecialchars($flash_success) ?>
                        </div>
                    <?php endif; ?>
                    <form action="index.php?action=admin_book_store" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Book Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter book title">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Author <span class="text-danger">*</span></label>
                                <input type="text" name="author" class="form-control" required placeholder="Enter author name">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Category</label>
                                <select name="category_id" class="form-select">
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">ISBN</label>
                                <input type="text" name="isbn" class="form-control" placeholder="e.g. 978-3-16-148410-0">
                            </div>

                        
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Publisher</label>
                                <input type="text" name="publisher" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Publication Year</label>
                                <input type="number" name="published_year" class="form-control" value="2024">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Cover Image</label>
                                <input type="file" name="cover_image" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <a href="index.php?action=admin_books_index" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-check-lg"></i> Save Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin.js"></script>
</body>
</html>