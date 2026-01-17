<?php require_once '/views/layouts/header.php'; ?>
<?php require_once  '/views/layouts/navbar.php'; ?>

<div class="container">
    <!-- Banner/Search Section -->
    <div class="jumbotron library-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h1>THƯ VIỆN QUẢN LÝ SÁCH</h1>
        <p class="lead">Tìm kiếm và mượn sách trực tuyến - Hệ thống quản lý thư viện hiện đại</p>
        <form action="/books/search" method="GET" class="form-inline" style="margin-top: 30px;">
            <div class="input-group" style="width: 80%; margin: 0 auto;">
                <input type="text" name="q" class="form-control input-lg" placeholder="Nhập tên sách, tác giả hoặc ISBN..." required>
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Featured Books -->
    <h2 class="section-title" style="margin-top: 40px;">
        <i class="fa fa-star text-warning"></i> SÁCH NỔI BẬT
    </h2>
    <div class="row">
        <?php foreach ($featuredBooks as $book): ?>
        <div class="col-md-3 col-sm-6">
            <div class="book-card">
                <div class="book-img-wrapper">
                    <a href="/books/<?= $book['book_id'] ?>">
                        <img src="<?= $book['image_url'] ?? '/images/books/default.jpg' ?>" 
                             class="book-img" alt="<?= htmlspecialchars($book['title']) ?>"
                             onerror="this.src='/images/books/default.jpg'">
                    </a>
                    <span class="label-category"><?= $book['category_name'] ?></span>
                </div>
                <div class="book-body">
                    <h4 class="book-title">
                        <a href="/books/<?= $book['book_id'] ?>">
                            <?= htmlspecialchars($book['title']) ?>
                        </a>
                    </h4>
                    <p class="text-muted">
                        <i class="fa fa-user"></i> <?= htmlspecialchars($book['author']) ?>
                    </p>
                    <div class="row">
                        <div class="col-xs-7">
                            <i class="fa fa-copy"></i> 
                            <?= $book['available_copies'] ?? 0 ?> bản có sẵn
                        </div>
                        <div class="col-xs-5 text-right">
                            <?php if (($book['available_copies'] ?? 0) > 0): ?>
                                <span class="label label-success">CÓ SẴN</span>
                            <?php else: ?>
                                <span class="label label-danger">HẾT SÁCH</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Latest Books -->
    <h2 class="section-title" style="margin-top: 50px;">
        <i class="fa fa-clock-o text-primary"></i> SÁCH MỚI NHẤT
    </h2>
    <div class="row">
        <?php foreach ($latestBooks as $book): ?>
        <div class="col-md-3 col-sm-6">
            <div class="book-card">
                <div class="book-img-wrapper">
                    <a href="/books/<?= $book['book_id'] ?>">
                        <img src="<?= $book['image_url'] ?? '/images/books/default.jpg' ?>" 
                             class="book-img" alt="<?= htmlspecialchars($book['title']) ?>"
                             onerror="this.src='/images/books/default.jpg'">
                    </a>
                </div>
                <div class="book-body">
                    <h4 class="book-title">
                        <a href="/books/<?= $book['book_id'] ?>">
                            <?= htmlspecialchars(mb_substr($book['title'], 0, 50)) ?>
                            <?= mb_strlen($book['title']) > 50 ? '...' : '' ?>
                        </a>
                    </h4>
                    <p class="text-muted small">
                        <i class="fa fa-user"></i> <?= htmlspecialchars($book['author']) ?>
                    </p>
                    <p class="book-meta">
                        <i class="fa fa-tag"></i> <?= $book['category_name'] ?>
                    </p>
                    <a href="/books/<?= $book['book_id'] ?>" class="btn btn-primary btn-block btn-sm">
                        <i class="fa fa-eye"></i> Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Categories -->
    <h2 class="section-title" style="margin-top: 50px;">
        <i class="fa fa-folder-open text-info"></i> DANH MỤC SÁCH
    </h2>
    <div class="row">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-4 col-sm-6">
            <div class="category-card">
                <div class="category-icon">
                    <i class="fa fa-book fa-3x"></i>
                </div>
                <div class="category-info">
                    <h4><?= htmlspecialchars($category['category_name']) ?></h4>
                    <p class="text-muted">
                        <?= $category['description'] ?? 'Không có mô tả' ?>
                    </p>
                    <a href="/books/search?category=<?= $category['category_id'] ?>" class="btn btn-default btn-sm">
                        Xem sách <span class="badge"><?= rand(20, 100) ?></span>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once '/views/layouts/footer.php'; ?>