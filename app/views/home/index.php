<?php
    require_once __DIR__ . '/../layouts/header.php';
    require_once __DIR__ . '/../layouts/navbar.php';
?>
<div class="hero-section">
    <div class="container">
        <h1 class="hero-title">LIBRARY MANAGEMENT SYSTEM</h1>

        <form action="index.php?action=user_books_search" method="GET" class="hero-search-box">
            <input type="text" name="search" placeholder="Find the book you want...">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<div class="container" style="margin-top: 40px; margin-bottom: 60px;">
    <!-- Featured Books Section -->
    <div class="section-header-wrapper">
        <h2 class="section-header">
            <i class="fa fa-star"></i> Featured Books
        </h2>
        <a href="index.php?action=user_books_index" class="view-all-link">View all <i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="row">
        <?php if (!empty($featuredBooks)): ?>
            <?php foreach ($featuredBooks as $book): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <div class="book-img-wrapper">
                            <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                <img src="/public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                     class="book-img"
                                     alt="<?= htmlspecialchars($book['title']) ?>"
                                     onerror="this.src='/public/images/books/1984.jpg'">
                            </a>
                        </div>
                        <div class="book-body">
                            <h4 class="book-title">
                                <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                    <?= htmlspecialchars($book['title']) ?>
                                </a>
                            </h4>
                            <p class="book-author">
                                <i class="fa fa-user"></i> <?= htmlspecialchars($book['author']) ?>
                            </p>
                            <p class="book-availability">
                                <?php if (($book['available_copies'] ?? 0) > 0): ?>
                                    <span class="text-success">
                                        <i class="fa fa-check-circle"></i> 
                                        <?= $book['available_copies'] ?> Book availables
                                    </span>
                                <?php else: ?>
                                    <span class="text-danger">
                                        <i class="fa fa-times-circle"></i> Out of stock
                                    </span>
                                <?php endif; ?>
                            </p>
                            <?php if (!empty($book['category_name'])): ?>
                                <span class="label label-info">
                                    <?= htmlspecialchars($book['category_name']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No featured books available.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Latest Books Section -->
    <div class="section-header-wrapper" style="margin-top: 50px;">
        <h2 class="section-header">
            <i class="fa fa-clock-o"></i> Latest Books
        </h2>
        <a href="index.php?action=user_books_index" class="view-all-link">View all <i class="fa fa-arrow-right"></i></a>
    </div>

    <div class="row">
        <?php if (!empty($latestBooks)): ?>
            <?php foreach ($latestBooks as $book): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="book-card">
                        <div class="book-img-wrapper">
                            <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                <img src="/public<?= htmlspecialchars($book['image_url'] ?? '/images/books/1984.jpg') ?>" 
                                     class="book-img"
                                     alt="<?= htmlspecialchars($book['title']) ?>"
                                     onerror="this.src='/public/images/books/1984.jpg'">
                            </a>
                        </div>
                        <div class="book-body">
                            <h4 class="book-title">
                                <a href="index.php?action=user_books_show&id=<?= $book['book_id'] ?>">
                                    <?= htmlspecialchars($book['title']) ?>
                                </a>
                            </h4>
                            <p class="book-author">
                                <i class="fa fa-user"></i> <?= htmlspecialchars($book['author']) ?>
                            </p>
                            <p class="book-availability">
                                <?php if (($book['available_copies'] ?? 0) > 0): ?>
                                    <span class="text-success">
                                        <i class="fa fa-check-circle"></i> 
                                        <?= $book['available_copies'] ?> Book availables
                                    </span>
                                <?php else: ?>
                                    <span class="text-danger">
                                        <i class="fa fa-times-circle"></i> Out of stock
                                    </span>
                                <?php endif; ?>
                            </p>
                            <?php if (!empty($book['category_name'])): ?>
                                <span class="label label-info">
                                    <?= htmlspecialchars($book['category_name']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No latest books available.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Categories Section -->
    <div class="section-header-wrapper" style="margin-top: 50px;">
        <h2 class="section-header">
            <i class="fa fa-folder"></i> Categories
        </h2>
    </div>

    <div class="row">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $cat): ?>
                <div class="col-md-3 col-sm-6" style="margin-bottom: 20px;">
                    <a href="index.php?action=user_books_index&category=<?= $cat['category_id'] ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fa fa-folder-open"></i>
                        </div>
                        <h4><?= htmlspecialchars($cat['category_name']) ?></h4>
                        <?php if (!empty($cat['description'])): ?>
                            <p><?= htmlspecialchars($cat['description']) ?></p>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> No categories available.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
