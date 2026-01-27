<?php 
// Nạp các thành phần layout dùng chung
    require_once __DIR__ . '/../layouts/header.php';
    require_once __DIR__ . '/../layouts/navbar.php';
?>

<div class="container" style="min-height: 600px; padding-bottom: 50px;">
    
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <div style="border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 30px;">
                <h2 style="margin: 0; color: var(--dark-green);">
                    Search results for: "<span style="color: var(--primary-green);"><?= htmlspecialchars($keyword) ?></span>"
                </h2>
                <p class="text-muted" style="margin-top: 10px;">
                    Found <strong><?= count($books) ?></strong> matching results.
                </p>
                
                <form action="/books/search" method="GET" class="form-inline" style="margin-top: 15px;">
                    <div class="form-group" style="width: 50%;">
                        <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($keyword) ?>" placeholder="Enter a different keyword..." style="width: 100%;">
                    </div>
                    <button type="submit" class="btn btn-primary" style="background: var(--dark-green); border: none;">Search again</button>
                    <a href="/books" class="btn btn-default">Back to list</a>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
            <div class="col-md-3 col-sm-6">
                <div class="book-card">
                    <div class="book-img-wrapper">
                        <a href="/books/show/<?= $book['book_id'] ?>">
                            <img src="<?= htmlspecialchars($book['image_url'] ?? '/images/books/default.jpg') ?>" 
                                 class="book-img" 
                                 onerror="this.src='/images/books/default.jpg'">
                        </a>
                    </div>
                    
                    <div class="book-body">
                        <h4 class="book-title">
                            <a href="/books/show/<?= $book['book_id'] ?>">
                                <?= htmlspecialchars($book['title']) ?>
                            </a>
                        </h4>
                        <p class="book-author">
                            <?= htmlspecialchars($book['author']) ?>
                        </p>
                        <p class="book-availability">
                            <?= ($book['available_copies'] ?? 0) ?> Available copies
                        </p>
                        
                        <?php if(isset($book['category_name'])): ?>
                            <span class="label label-success" style="background: var(--light-green-bg); color: var(--dark-green); border: 1px solid var(--primary-green);">
                                <?= htmlspecialchars($book['category_name']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12 text-center" style="margin-top: 50px;">
                <i class="fa fa-search fa-4x" style="color: #ddd;"></i>
                <h3 style="color: #7f8c8d; margin-top: 20px;">No results found.</h3>
                <p>Try searching with a different keyword or check for typos.</p>
                <a href="/books" class="btn btn-lg btn-primary" style="background: var(--primary-green); border: none; margin-top: 20px;">View all books</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>
