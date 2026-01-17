<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/navbar.php'; ?>>

<div class="hero-section">
    <div class="container">
        <h1 class="hero-title">THƯ VIỆN SỐ TRỰC TUYẾN</h1>
        <p style="color: #e8f5e9; margin-bottom: 20px;">Kết nối tri thức - Khơi nguồn sáng tạo</p>
        
        <form action="/books" method="GET" class="hero-search-box">
            <input type="text" name="q" placeholder="Nhập tên sách, tác giả hoặc ISBN..." required>
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<div class="container" style="min-height: 600px;">
    
    <h2 class="section-header"><i class="fa fa-star"></i> Sách Nổi Bật</h2>
    <div class="row">
        <?php if (!empty($featuredBooks)): ?>
            <?php foreach ($featuredBooks as $book): ?>
            <div class="col-md-3 col-sm-6">
                <div class="book-card">
                    <div class="book-img-wrapper">
                        <a href="/books/show/<?= $book['book_id'] ?>">
                            <img src="<?= htmlspecialchars($book['image_url'] ?? '') ?>" 
                                 class="book-img" 
                                 alt="<?= htmlspecialchars($book['title']) ?>"
                                 onerror="this.src='/public/images/books/default.jpg'">
                        </a>
                    </div>
                    <div class="book-body">
                        <h4 class="book-title">
                            <a href="/books/show/<?= $book['book_id'] ?>"><?= htmlspecialchars($book['title']) ?></a>
                        </h4>
                        <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
                        <p class="book-availability" style="<?= $book['available_copies'] > 0 ? '' : 'color:red' ?>">
                            <?= $book['available_copies'] > 0 ? 'Còn '.$book['available_copies'].' cuốn' : 'Hết sách' ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h2 class="section-header" style="margin-top: 50px;"><i class="fa fa-clock-o"></i> Sách Mới Cập Nhật</h2>
    <div class="row">
        <?php if (!empty($latestBooks)): ?>
            <?php foreach ($latestBooks as $book): ?>
            <div class="col-md-3 col-sm-6">
                <div class="book-card">
                    <div class="book-img-wrapper">
                        <a href="/books/show/<?= $book['book_id'] ?>">
                            <img src="<?= htmlspecialchars($book['image_url'] ?? '') ?>" 
                                 class="book-img" 
                                 onerror="this.src='/public/images/books/default.jpg'">
                        </a>
                    </div>
                    <div class="book-body">
                        <h4 class="book-title">
                            <a href="/books/show/<?= $book['book_id'] ?>"><?= htmlspecialchars($book['title']) ?></a>
                        </h4>
                        <p class="book-author"><?= htmlspecialchars($book['author']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <h2 class="section-header" style="margin-top: 50px;"><i class="fa fa-list"></i> Danh Mục Sách</h2>
    <div class="row">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
            <div class="col-md-3 col-sm-6">
                <a href="/books?category=<?= $cat['category_id'] ?>" style="text-decoration: none;">
                    <div class="category-card">
                        <div class="category-icon"><i class="fa fa-book"></i></div>
                        <h4><?= htmlspecialchars($cat['category_name']) ?></h4>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>