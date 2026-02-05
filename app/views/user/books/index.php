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
                <form action="index.php" method="GET" class="input-group w-50">
                    <input type="hidden" name="action" value="user_books_search">
                    <input type="text" name="search" class="form-control border-success search-input" placeholder="Search books..." value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                    <button class="btn btn-success" type="submit" style="background-color: #16A34A;"><i class="fa fa-search"></i></button>
                </form>
               
            </div>

            <div class="row g-4">
                <?php if (!empty($books)): ?>
                    <?php foreach ($books as $book): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm book-card-hover">
                            <div class="position-relative overflow-hidden" style="height: 280px;">
                                <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                    <img src="/public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                        class="book-img"
                                        alt="<?= htmlspecialchars($book['title']) ?>"
                                        onerror="this.src='/public/images/books/1984.jpg'">
                                </a>
                                
                                <?php if(($book['available_copies'] ?? 0) > 0): ?>
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
                                    <a href="index.php?action=user_books_borrow_request&id=<?= $book['book_id'] ?>" class="btn btn-success btn-sm flex-grow-1 fw-bold">Borrow</a>
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

            <?php
            $totalPages = (int)($totalPages ?? 1);
            $currentPage = (int)($currentPage ?? 1);
            $totalBooks = (int)($totalBooks ?? 0);
            $searchQuery = $searchQuery ?? '';
            $selectedCategory = $selectedCategory ?? '';
            $baseParams = ['action' => 'user_books_index'];
            if ($searchQuery !== '') $baseParams['search'] = $searchQuery;
            if ($selectedCategory !== '') $baseParams['category'] = $selectedCategory;
            ?>
            <?php if ($totalPages > 1): ?>
            <nav class="mt-5" aria-label="Phân trang sách">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <p class="text-muted small mb-0">
                        Trang <?= $currentPage ?> / <?= $totalPages ?>
                        (<?= $totalBooks ?> sách)
                    </p>
                    <ul class="pagination justify-content-center mb-0">
                        <?php
                        $prevParams = $baseParams;
                        $prevParams['page'] = $currentPage - 1;
                        $prevUrl = 'index.php?' . http_build_query($prevParams);
                        ?>
                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link text-success" href="<?= $currentPage <= 1 ? '#' : $prevUrl ?>">Previous</a>
                        </li>

                        <?php
                        $start = max(1, $currentPage - 2);
                        $end = min($totalPages, $currentPage + 2);
                        for ($i = $start; $i <= $end; $i++):
                            $pageParams = $baseParams;
                            $pageParams['page'] = $i;
                            $pageUrl = 'index.php?' . http_build_query($pageParams);
                        ?>
                        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                            <a class="page-link <?= $i === $currentPage ? 'bg-success border-success text-white' : 'text-success' ?>" href="<?= $pageUrl ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php
                        $nextParams = $baseParams;
                        $nextParams['page'] = $currentPage + 1;
                        $nextUrl = 'index.php?' . http_build_query($nextParams);
                        ?>
                        <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link text-success" href="<?= $currentPage >= $totalPages ? '#' : $nextUrl ?>">Next</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php endif; ?>
        </main>
    </div>
</div>

<link rel="stylesheet" href="/public/css/user.css">

<?php require_once __DIR__ . '/../../layouts/footer.php';?>
