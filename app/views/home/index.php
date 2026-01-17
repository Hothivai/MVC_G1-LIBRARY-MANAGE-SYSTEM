<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>>

<div class="hero-section">
    <div class="container">
        <h1 class="hero-title">LIBRARY MANAGEMENT SYSTEM</h1>
        
        <form action="/books/search" method="GET" class="hero-search-box">
            <input type="text" name="q" placeholder="Find the book you want..." required>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </form>
    </div>
</div>

<div class="container">
    <h2 class="section-header">Top books</h2>
    
    <div class="row">
        <?php if (!empty($featuredBooks)): ?>
            <?php foreach ($featuredBooks as $book): ?>
            <div class="col-md-3 col-sm-6">
                <div class="book-card">
                    <div class="book-img-wrapper">
                        <a href="/books/<?= $book['book_id'] ?>">
                            <img src="<?= $book['image_url'] ?? '/images/books/default.jpg' ?>" 
                                 class="book-img" 
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 onerror="this.src='/images/books/default.jpg'">
                        </a>
                    </div>
                    
                    <h4 class="book-title">
                        <a href="/books/<?= $book['book_id'] ?>" style="text-decoration: none; color: inherit;">
                            <?= htmlspecialchars($book['title']) ?>
                        </a>
                    </h4>
                    
                    <p class="book-author">Author: <?= htmlspecialchars($book['author']) ?></p>
                    
                    <p class="book-availability">
                        <?= $book['available_copies'] ?> books available
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Chưa có sách nổi bật nào.</p>
        <?php endif; ?>
    </div>

    <h2 class="section-header" style="margin-top: 40px;">Categories</h2>
    
    <div class="row">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 col-sm-6">
                <a href="/books/search?category=<?= $cat['category_id'] ?>" style="text-decoration: none;">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fa fa-desktop"></i> </div>
                        <h4 style="font-weight: bold; color: #333;"><?= htmlspecialchars($cat['category_name']) ?></h4>
                        <span style="color: var(--primary-green); font-size: 12px;">
                            <?= rand(50, 100) ?> books
                        </span>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>