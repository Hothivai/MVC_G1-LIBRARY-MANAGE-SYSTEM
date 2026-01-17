<?php
/**
 * Book Detail View (User)
 * Displays detailed information about a single book
 */
require_once __DIR__ . '/../../layouts/header.php';
?>

<div class="book-detail">
    <div class="container">
        <a href="/book" class="btn btn-outline" style="margin-bottom: 2rem;">
            <i class="fas fa-arrow-left"></i> Back to Books
        </a>

        <div class="book-detail-container">
            <!-- Book Cover -->
            <div class="book-detail-cover">
                <?php if (!empty($book['image_url'])): ?>
                    <img src="/<?= htmlspecialchars($book['image_url']) ?>"
                        alt="<?= htmlspecialchars($book['title']) ?>">
                <?php else: ?>
                    <div class="book-placeholder" style="width:100%;height:100%;">
                        <span><?= strtoupper(substr($book['title'], 0, 1)) ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Book Information -->
            <div class="book-detail-info">
                <h1><?= htmlspecialchars($book['title']) ?></h1>
                
                <div class="book-category" style="margin-bottom: 20px;">
                    <span class="badge" style="background: #e3f2fd; color: #1976d2; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem;">
                        <i class="fas fa-folder"></i> <?= htmlspecialchars($book['category_name']) ?>
                    </span>
                </div>

                <div class="book-meta">
                    <div class="book-meta-item">
                        <span class="book-meta-label"><i class="fas fa-user-pen"></i> Author:</span>
                        <span class="book-meta-value"><?= htmlspecialchars($book['author']) ?></span>
                    </div>

                    <?php if (!empty($book['isbn'])): ?>
                        <div class="book-meta-item">
                            <span class="book-meta-label"><i class="fas fa-barcode"></i> ISBN:</span>
                            <span class="book-meta-value"><?= htmlspecialchars($book['isbn']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($book['publisher'])): ?>
                        <div class="book-meta-item">
                            <span class="book-meta-label"><i class="fas fa-building"></i> Publisher:</span>
                            <span class="book-meta-value"><?= htmlspecialchars($book['publisher']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($book['published_year'])): ?>
                        <div class="book-meta-item">
                            <span class="book-meta-label"><i class="fas fa-calendar"></i> Year:</span>
                            <span class="book-meta-value"><?= htmlspecialchars($book['published_year']) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="book-meta-item">
                        <span class="book-meta-label"><i class="fas fa-copy"></i> Availability:</span>
                        <span class="book-meta-value">
                            <?php if ($book['available_copies'] > 0): ?>
                                <span class="book-status available">
                                    <i class="fas fa-check-circle"></i> 
                                    Available (<?= $book['available_copies'] ?> copies)
                                </span>
                            <?php else: ?>
                                <span class="book-status unavailable">
                                    <i class="fas fa-times-circle"></i> Currently Unavailable
                                </span>
                            <?php endif; ?>
                        </span>
                    </div>
                    
                    <div class="book-meta-item">
                        <span class="book-meta-label"><i class="fas fa-book"></i> Total Copies:</span>
                        <span class="book-meta-value"><?= $book['total_copies'] ?? 0 ?></span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="book-actions">
                    <?php if (isset($canBorrow) && $canBorrow && $book['available_copies'] > 0): ?>
                        <a href="/borrow/request/<?= $book['book_id'] ?>" class="btn btn-primary">
                            <i class="fas fa-book-reader"></i> Borrow this book
                        </a>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="/auth/login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login to borrow
                        </a>
                    <?php elseif (isset($_SESSION['is_suspended']) && $_SESSION['is_suspended']): ?>
                        <button class="btn btn-primary" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-ban"></i> Account Suspended
                        </button>
                    <?php else: ?>
                        <button class="btn btn-primary" disabled style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-clock"></i> Currently Unavailable
                        </button>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (isset($isFavorited) && $isFavorited): ?>
                            <a href="/favorite/remove/<?= $book['book_id'] ?>" class="btn btn-outline">
                                <i class="fas fa-star"></i> Remove from Favorites
                            </a>
                        <?php else: ?>
                            <a href="/favorite/add/<?= $book['book_id'] ?>" class="btn btn-outline">
                                <i class="far fa-star"></i> Add to Favorites
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <?php if (!empty($book['description'])): ?>
                    <div class="book-description">
                        <h3><i class="fas fa-align-left"></i> Description</h3>
                        <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related Books -->
        <?php if (!empty($relatedBooks)): ?>
            <div class="related-books">
                <h3><i class="fas fa-book-open"></i> Related Books</h3>
                <div class="books-grid">
                    <?php foreach ($relatedBooks as $relatedBook): ?>
                        <a href="/book/show/<?= $relatedBook['book_id'] ?>" class="book-card">
                            <div class="book-cover">
                                <?php if (!empty($relatedBook['image_url'])): ?>
                                    <img src="/<?= htmlspecialchars($relatedBook['image_url']) ?>"
                                        alt="<?= htmlspecialchars($relatedBook['title']) ?>">
                                <?php else: ?>
                                    <div class="book-placeholder">
                                        <span><?= strtoupper(substr($relatedBook['title'], 0, 1)) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <h3 class="book-title"><?= htmlspecialchars($relatedBook['title']) ?></h3>
                                <p class="book-author"><?= htmlspecialchars($relatedBook['author']) ?></p>
                                <p class="book-availability">
                                    <?= $relatedBook['available_copies'] ?> available
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>