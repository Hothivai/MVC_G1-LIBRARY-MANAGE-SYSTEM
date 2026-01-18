<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>

<div class="container">
    <h2><i class="fa fa-book"></i> Tất cả sách</h2>

    <div class="row">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <img src="<?= $book['image_url'] ?? '/images/books/default.jpg' ?>">
                        <h4><?= htmlspecialchars($book['title']) ?></h4>
                        <p><?= htmlspecialchars($book['author']) ?></p>
                        <span>
                            <?= ($book['available_copies'] ?? 0) > 0 ? 'Có sẵn' : 'Hết sách' ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy cuốn sách nào.</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
