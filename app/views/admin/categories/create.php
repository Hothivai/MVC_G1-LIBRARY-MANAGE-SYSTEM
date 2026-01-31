<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1 bg-light">
        <nav class="navbar navbar-light bg-white px-4 border-bottom">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-folder-plus me-2 text-success"></i>Add New Category
            </span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="index.php?action=admin_categories_index" class="text-decoration-none">Categories</a></li>
                        <li class="breadcrumb-item active">Add Category</li>
                    </ol>
                </nav>
            </div>

            <div class="card border-0 shadow-sm" style="max-width: 700px; margin: 0 auto;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-info-circle text-primary me-2"></i>Category Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="index.php?action=admin_category_store" method="POST" id="categoryForm">
                        <div class="form-section">
                            <div class="form-section-title">
                                <i class="bi bi-tag me-2"></i>Basic Information
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">
                                    <i class="bi bi-bookmark text-primary me-1"></i>Category Name 
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <i class="bi bi-tag form-icon"></i>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control form-control-lg form-control-with-icon" 
                                           required 
                                           placeholder="Enter category name"
                                           autofocus>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Choose a clear and descriptive name for the category
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold mb-2">
                                    <i class="bi bi-file-text text-primary me-1"></i>Description
                                </label>
                                <div class="position-relative">
                                    <i class="bi bi-file-text form-icon" style="top: 20px;"></i>
                                    <textarea name="description" 
                                              class="form-control form-control-with-icon" 
                                              rows="4"
                                              placeholder="Enter category description (optional)"></textarea>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Provide additional details about this category
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="index.php?action=admin_categories_index" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-check-circle me-2"></i>Create Category
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
<script>
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const nameInput = this.querySelector('input[name="name"]');
    if (nameInput.value.trim() === '') {
        e.preventDefault();
        alert('Please enter a category name');
        nameInput.focus();
        return false;
    }
});
</script>
</body>
</html>
