<?php
require_once __DIR__ . '/../../layouts/header.php';
require_once __DIR__ . '/../../layouts/navbar.php';
?>

<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="row">
        <aside class="col-md-3">
            <div class="filter-section shadow-sm p-4 bg-white rounded border-top border-success border-4">
                <h4 class="fw-bold mb-4 text-success"><i class="fa fa-filter me-2"></i>Filter</h4>

                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="user_books_index">
                    <div class="mb-4">
                        <label class="fw-bold mb-2">Categories</label>

                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <div class="form-check mb-1">
                                    <input
                                        class="form-check-input accent-success"
                                        type="radio"
                                        name="category"
                                        value="<?= $cat['category_id'] ?>"
                                        <?= ($selectedCategory == $cat['category_id']) ? 'checked' : '' ?>>
                                    <label class="form-check-label small">
                                        <?= htmlspecialchars($cat['category_name']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted small">No categories found.</p>
                        <?php endif; ?>

                    </div>

                    <div class="mb-4">
                        <label class="fw-bold mb-2">Status</label>
                        <div class="form-check mb-1">
                            <input class="form-check-input accent-success" type="checkbox" checked>
                            <label class="form-check-label small text-success fw-bold">Available</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input accent-success" type="checkbox">
                            <label class="form-check-label small">Borrowing</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #16A34A; border: none;">
                        Apply filters
                    </button>
                    <a href="index.php?action=user_books_index" class="btn btn-link w-100 mt-2 text-decoration-none text-muted small">Clear filters</a>
                </form>
            </div>
        </aside>

        <main class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <form action="index.php?action=user_books_search" method="GET" class="input-group w-50">
                    <input type="text" name="search" class="form-control border-success" placeholder="Search books...">
                    <button class="btn btn-success" type="button" style="background-color: #16A34A;"><i class="fa fa-search"></i></button>
                </form>
                <div class="d-flex align-items-center">
                    <label class="me-2 small text-muted">Sort by:</label>
                    <select class="form-select form-select-sm border-success">
                        <option>Newest</option>
                        <option>Oldest</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm book-card-hover">
                                <div class="position-relative overflow-hidden" style="height: 280px;">
                                    <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                        <img src="../../../public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>"
                                            class="book-img"
                                            alt="<?= htmlspecialchars($book['title']) ?>"
                                            onerror="this.src='../../../public/images/books/1984.jpg'">
                                    </a>

                                    <?php if (($book['available_copies'] ?? 0) > 0): ?>
                                        <span class="badge bg-success position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm">Book available</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm">Out of stock</span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body p-3">
                                    <p class="text-muted small mb-1"><?= htmlspecialchars($book['category_name'] ?? 'Chưa phân loại') ?></p>
                                    <h6 class="card-title fw-bold text-dark mb-1 line-clamp-2"><?= htmlspecialchars($book['title']) ?></h6>
                                    <p class="card-text small text-secondary mb-3">by <?= htmlspecialchars($book['author']) ?></p>

                                    <div class="d-flex gap-2">
                                        <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>" class="btn btn-outline-success btn-sm flex-grow-1 border-2 fw-bold">Detail</a>
                                        <?php if (($book['available_copies'] ?? 0) > 0): ?>
                                            <a href="index.php?action=user_books_borrow_request&id=<?= $book['book_id'] ?>" class="btn btn-success btn-sm flex-grow-1 fw-bold" style="background-color: #16A34A;">Borrow</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-book fa-3x text-light-green mb-3"></i>
                        <p class="text-muted">No books found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link text-success" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link bg-success border-success" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">Next</a></li>
                </ul>
            </nav>
        </main>
    </div>
</div>

<style>
    /* Custom CSS để đồng bộ màu xanh lá cây của dự án */
    :root {
        --primary-green: #2ecc71;
        --dark-green: #145c38;
    }

    .accent-success {
        accent-color: #16A34A;
    }

    .book-card-hover {
        transition: all 0.3s ease;
        border-radius: 12px;
    }

    .book-card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pagination .page-link {
        color: #16A34A;
        border-radius: 8px;
        margin: 0 3px;
    }

    .bg-success {
        background-color: #16A34A !important;
    }

    .btn-outline-success {
        color: #16A34A;
        border-color: #16A34A;
    }

    .btn-outline-success:hover {
        background-color: #16A34A;
        color: white;
    }
</style>

<?php require_once __DIR__ . '/../../layouts/footer.php';?>
