<?php 
require_once dirname(__DIR__, 2) . '/layouts/header.php';
require_once dirname(__DIR__, 2) . '/layouts/navbar.php';
?>

<div class="container mt-4 mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb py-3 px-4 shadow-sm" style="background-color: #16A34A;">
            <li class="breadcrumb-item"><a href="index.php?action=home_index" class="text-white text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>" class="text-white text-decoration-none">Book Detail</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Borrow Request</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden rounded-4">
                <div class="row g-0">
                    <div class="col-md-4 bg-light p-4 text-center border-end">
                        <h5 class="text-success fw-bold mb-4">BOOK INFORMATION</h5>
                                <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                    <img src="../../../public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                        class="book-img"
                                        alt="<?= htmlspecialchars($book['title']) ?>"
                                        onerror="this.src='../../../public/images/books/1984.jpg'">
                                </a>
                        <h6 class="fw-bold mb-1"><?= htmlspecialchars($book['title']) ?></h6>
                        <p class="text-muted small">Author: <?= htmlspecialchars($book['author']) ?></p>
                        <div class="badge bg-success-light text-success border border-success px-3 py-2 mt-2">
                            Available: <?= $book['available_copies'] ?> copies
                        </div>
                    </div>

                    <div class="col-md-8 p-5 bg-white">
                        <h3 class="fw-bold text-dark mb-4">Borrow Request Form</h3>
                        <p class="text-muted mb-4">Please review the information and select the expected return date.</p>

                        <form action="index.php?action=home_index" method="POST">
                            <input type="hidden" name="book_id" value="<?= $book['book_id'] ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Borrower</label>
                                    <input type="text" class="form-control bg-light" value="<?= $_SESSION['user_name'] ?? 'Member' ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-uppercase text-muted">Borrow Date</label>
                                    <input type="text" class="form-control bg-light" value="<?= date('d/m/Y') ?>" readonly>
                                </div>

                                <div class="col-12 mt-4">
                                    <label for="due_date" class="form-label small fw-bold text-uppercase text-success">Expected Return Date *</label>
                                    <input type="date" name="due_date" id="due_date" class="form-control border-success py-3" 
                                           min="<?= date('Y-m-d', strtotime('+1 day')) ?>" 
                                           max="<?= date('Y-m-d', strtotime('+14 days')) ?>" required>
                                    <div class="form-text text-muted italic">Note: Maximum borrowing period is 14 days.</div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label for="notes" class="form-label small fw-bold text-uppercase text-muted">Add Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="For example: I will take good care of the book..."></textarea>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="alert alert-warning border-0 small py-2 px-3">
                                        <i class="fa fa-info-circle me-2"></i> By clicking "Confirm", you agree to the library's policy on returning books on time.
                                    </div>
                                </div>

                                <div class="col-12 mt-2 d-flex gap-3">
                                    <button type="submit" class="btn btn-success flex-grow-1 py-3 fw-bold shadow-sm" style="background-color: #16A34A; border: none;">
                                        CONFIRM BORROW
                                    </button>
                                    <a href="index.php?action=book_detail&id=<?= $book['book_id'] ?>" class="btn btn-outline-secondary py-3 px-4">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS đồng bộ màu sắc */
.bg-success-light {
    background-color: #f0fdf4;
}

.form-control:focus {
    border-color: #16A34A;
    box-shadow: 0 0 0 0.25rem rgba(22, 163, 74, 0.1);
}

.card {
    border-radius: 1rem;
}

.breadcrumb {
    border-radius: 0.75rem;
}

.btn-success:hover {
    background-color: #145c38 !important;
    transform: translateY(-2px);
    transition: all 0.2s;
}
</style>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>
