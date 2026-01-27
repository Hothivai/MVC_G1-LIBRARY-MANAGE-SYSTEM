<?php
require_once dirname(__DIR__,2) . '/layouts/header.php';
require_once dirname(__DIR__,2) . '/layouts/navbar.php';
?>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb py-3 px-4 shadow-sm" style="background-color: #16A34A;">
            <li class="breadcrumb-item"><a href="index.php?action=home_index" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=user_books_index" class="text-white text-decoration-none">Book</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page"><?= htmlspecialchars($book['title']) ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-4 text-center">
            <div class="book-cover-container p-4 bg-white shadow-sm rounded border">
                                <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                    <img src="../../../public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                        class="book-img"
                                        alt="<?= htmlspecialchars($book['title']) ?>"
                                        onerror="this.src='../../../public/images/books/1984.jpg'">
                                </a>

                <div class="mt-4 d-grid gap-3">
                    <a href="index.php?action=user_books_borrow_request&id=<?= $book['book_id'] ?>" 
                       class="btn btn-success py-3 fw-bold shadow-sm" style="background-color: #16A34A; border: none;">
                       <i class="fa fa-book-reader me-2"></i>Borrow books
                    </a>
                    <button class="btn btn-outline-success py-3 fw-bold border-2" style="color: #16A34A; border-color: #16A34A;">
                       <i class="fa fa-heart me-2"></i>Add to favorites
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="ps-md-4">
                <h1 class="display-5 fw-bold text-dark mb-2"><?= htmlspecialchars($book['title']) ?></h1>
                <p class="fs-5 text-secondary mb-4">Author: <span class="fw-bold text-dark"><?= htmlspecialchars($book['author']) ?></span></p>

                <div class="row mb-5 g-4">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 text-uppercase fw-bold">ISBN</small>
                        <span class="fs-6"><?= htmlspecialchars($book['isbn'] ?? 'N/A') ?></span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 text-uppercase fw-bold">Category</small>
                        <span class="badge px-3 py-2 border text-dark fw-normal bg-light"><?= htmlspecialchars($book['category_name']) ?></span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 text-uppercase fw-bold">Publication Year</small>
                        <span class="fs-6"><?= htmlspecialchars($book['published_year'] ?? '2023') ?></span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1 text-uppercase fw-bold">Quantity</small>
                        <span class="badge bg-light border text-dark px-3 py-2 fw-normal"><?= $book['total_copies'] ?? 0 ?></span>
                    </div>
                </div>

                <div class="description-box mb-5">
                    <p class="text-muted lh-lg">
                        <?= nl2br(htmlspecialchars($book['description'] ?? 'No description available for this book.')) ?>
                    </p>
                </div>

                <div class="row pt-4 border-top">
                    <div class="col-4">
                        <small class="text-muted d-block">Date added to system</small>
                        <span class="fw-bold small"><?= date('d/m/Y', strtotime($book['created_at'] ?? 'now')) ?></span>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">Borrow count</small>
                        <span class="fw-bold small">0 times</span>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">Price</small>
                        <span class="fw-bold text-success">150.000 VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Đồng bộ hóa giao diện */
.breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255,255,255,0.6);
}

.book-cover-container {
    transition: transform 0.3s ease;
}

.book-cover-container:hover {
    transform: translateY(-5px);
}

.description-box {
    border-left: 4px solid #16A34A;
    padding-left: 20px;
    background-color: #f9fdfa;
    padding-top: 15px;
    padding-bottom: 15px;
}

.text-success {
    color: #16A34A !important;
}

.btn-success:hover {
    background-color: #145c38 !important;
}
</style>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
