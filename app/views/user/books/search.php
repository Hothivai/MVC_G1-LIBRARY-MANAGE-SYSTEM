<?php
/**
 * Search Books View
 */
require_once __DIR__ . '/../../layouts/header.php';
?>

<section class="search-books">
    <div class="container" style="padding: 2rem 0;">
        <h1 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-search"></i> Tìm Kiếm Sách
        </h1>

        <form method="GET" action="/book/search" style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 10px; max-width: 600px;">
                <input type="text" name="q" placeholder="Tìm kiếm sách theo tên, tác giả, ISBN..." 
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" 
                       style="flex: 1; padding: 12px 20px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem;">
                <button type="submit" class="btn btn-primary" style="padding: 12px 30px;">
                    <i class="fas fa-search"></i> Tìm Kiếm
                </button>
            </div>
        </form>

        <?php if (isset($books) && is_array($books)): ?>
            <?php if (!empty($books)): ?>
                <!-- Results Info -->
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                    <p style="color: var(--text-light); margin: 0;">
                        <i class="fas fa-info-circle"></i>
                        Tìm thấy <strong><?= count($books) ?></strong> kết quả cho từ khóa 
                        "<strong><?= htmlspecialchars($searchQuery) ?></strong>"
                    </p>
                </div>

                <!-- Books Grid -->
                <div class="books-grid">
                    <?php foreach ($books as $book): ?>
                        <a href="/book/show/<?= $book['book_id'] ?>" class="book-card">
                            <div class="book-cover">
                                <?php if (!empty($book['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($book['image_url']) ?>"
                                        alt="<?= htmlspecialchars($book['title']) ?>">
                                <?php else: ?>
                                    <div class="book-placeholder">
                                        <span><?= strtoupper(substr($book['title'], 0, 1)) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?= htmlspecialchars($book['title']) ?></h3>
                                <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
                                <p class="book-availability">
                                    <i class="fas fa-book"></i> 
                                    <?= $book['available_copies'] ?> sách có sẵn
                                </p>
                                <p class="book-category" style="font-size: 0.9rem; color: #7f8c8d; margin-top: 8px;">
                                    <i class="fas fa-folder"></i> <?= htmlspecialchars($book['category_name']) ?>
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- No Results -->
                <div class="empty-state">
                    <svg class="empty-state-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20M4 19.5V4.5A2.5 2.5 0 0 1 6.5 2H17l5 5v10"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3>Không tìm thấy sách</h3>
                    <p>Không có kết quả phù hợp với từ khóa "<strong><?= htmlspecialchars($searchQuery) ?></strong>"</p>
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <a href="/book" class="btn btn-primary">
                            <i class="fas fa-book"></i> Xem tất cả sách
                        </a>
                        <a href="/book/search" class="btn btn-outline">
                            <i class="fas fa-redo"></i> Tìm kiếm lại
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>