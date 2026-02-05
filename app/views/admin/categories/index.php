<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1">
            <nav class="navbar navbar-dark bg-success px-4">
                <span class="navbar-brand">Category Management</span>
                <div class="text-white fs-5 d-flex align-items-center gap-3">
                    <?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Admin') ?>
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                </div>
            </nav>

        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Category List</h5>
                <a href="index.php?action=admin_categories_create" class="btn btn-success text-white fw-bold">
                    <i class="bi bi-plus-lg"></i> Add Category
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?= $cat['category_id'] ?></td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success fs-6 fw-normal border border-success">
                                            <?= htmlspecialchars($cat['category_name']) ?>
                                        </span>
                                    </td>
                                    <td class="text-muted"><?= htmlspecialchars($cat['description'] ?? 'No description') ?></td>
                                    <td class="text-center">
                                        <a href="index.php?action=admin_categories_edit&id=<?= $cat['category_id'] ?>" 
                                           class="btn btn-sm btn-outline-warning mx-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger mx-1">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4">No categories found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin.js"></script>
</body>
</html>