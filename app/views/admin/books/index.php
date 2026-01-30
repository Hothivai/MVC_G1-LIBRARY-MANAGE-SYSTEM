<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
    <style>
        /* CSS Riêng cho trang Book Management theo thiết kế */
        .book-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            transition: 0.3s;
            background: #fff;
        }
        .book-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .book-cover-placeholder {
            background-color: #e0e0e0; /* Màu xám giống thiết kế */
            height: 180px;
            width: 100%;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .book-cover-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .action-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #fd7e14; /* Màu cam giống hình */
            transition: 0.2s;
        }
        .action-btn:hover {
            background: #fd7e14;
            color: white;
            border-color: #fd7e14;
        }
        .action-btn.delete:hover {
            background: #dc3545;
            border-color: #dc3545;
        }
        .page-link-custom {
            color: #333;
            border: 1px solid #dee2e6;
            margin: 0 5px;
            border-radius: 4px;
            padding: 8px 16px;
            text-decoration: none;
        }
        .page-link-custom.active {
            background-color: #e0e0e0;
            border-color: #ccc;
            font-weight: bold;
        }
    </style>
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
                                <img src="../../../public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                     class="book-cover-img" 
                                     alt="<?= htmlspecialchars($book['title']) ?>"
                                     onerror="this.src='../../../public/images/books/1984.jpg'">
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

<script>
function confirmDelete(id) {
    if(confirm('Are you sure you want to delete this book?')) {
        window.location.href = 'index.php?action=admin_books_delete&id=' + id;
    }
}
</script>
</body>
</html>