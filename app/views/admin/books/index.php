<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>

<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1">
        <nav class="navbar navbar-light bg-white px-4 border-bottom">
            <span class="navbar-brand fw-bold">Book Management</span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Book list</h5>

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <form action="index.php" method="GET" class="position-relative">
                        <input type="hidden" name="action" value="admin_books_index">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" name="search" class="form-control ps-5" 
                               placeholder="Search books..." value="<?= htmlspecialchars($searchQuery) ?>">
                    </form>
                </div>

                <div class="col-md-3">
                    <form action="index.php" method="GET" id="filterForm">
                        <input type="hidden" name="action" value="admin_books_index">
                        <?php if($searchQuery): ?>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($searchQuery) ?>">
                        <?php endif; ?>
                        
                        <select class="form-select fw-bold" name="category" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>" <?= ($selectedCategory == $cat['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <div class="col-md-5 text-end">
                    <a href="index.php?action=admin_books_import" class="btn btn-outline-dark fw-bold me-2">
                        <i class="bi bi-upload"></i> IMPORT BOOK
                    </button>
                    <a href="index.php?action=admin_books_create" class="btn btn-outline-dark fw-bold">
                        <i class="bi bi-plus-lg"></i> ADD BOOK
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="book-card p-3 h-100 d-flex flex-column">
                            <div class="book-cover-placeholder mb-3">
                                <?php 
                                    $imagePath = $book['cover_image'] ?? $book['image_url'] ?? '/images/books/1984.jpg';
                                    if (substr($imagePath, 0, 1) !== '/') {
                                        $imagePath = '/' . $imagePath;
                                    }
                                ?>
                                <img src="/public<?= htmlspecialchars($imagePath) ?>" 
                                     class="book-cover-img" 
                                     alt="<?= htmlspecialchars($book['title']) ?>"
                                     onerror="this.src='/public/images/books/1984.jpg'">
                            </div>
                            <h6 class="fw-bold mb-1 text-truncate" title="<?= htmlspecialchars($book['title']) ?>">
                                <?= htmlspecialchars($book['title']) ?>
                            </h6>
                            <p class="text-muted small mb-1"><?= htmlspecialchars($book['author']) ?></p>
                            
                            <?php 
                                $available = $book['available_copies'] ?? 0;
                                $total = $book['total_copies'] ?? 0;
                            ?>
                            <div class="small mb-3">
                                <?php if($available > 0): ?>
                                    <?= $available ?>/<?= $total ?> remaining
                                <?php else: ?>
                                    <span class="text-danger fw-bold">Sold out</span>
                                <?php endif; ?>
                            </div>

                            <div class="mt-auto d-flex justify-content-between">
                                <a href="index.php?action=admin_books_show&id=<?= $book['book_id'] ?>" 
                                   class="action-btn" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="index.php?action=admin_books_edit&id=<?= $book['book_id'] ?>" 
                                   class="action-btn" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="#" onclick="confirmDelete(<?= $book['book_id'] ?>)" 
                                   class="action-btn delete" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No books found matching your criteria.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($totalPages > 1): ?>
            <div class="d-flex justify-content-center mt-5">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="index.php?action=admin_books_index&page=<?= $i ?>&search=<?= urlencode($searchQuery) ?>&category=<?= $selectedCategory ?>" 
                       class="page-link-custom <?= ($i == $currentPage) ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin.js"></script>
</body>
</html>