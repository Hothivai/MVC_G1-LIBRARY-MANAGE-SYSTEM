<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../../layouts/navbar.php'; ?>
<div class="container" style="min-height: 600px; padding-bottom: 50px;">
    <div class="row" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="col-md-12">
            <div style="background: #e9f7ef; padding: 20px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <h2 style="margin: 0; color: var(--dark-green); font-weight: 700;">
                    <i class="fa fa-book"></i> Tất cả sách
                </h2>
                
                <form action="/books" method="GET" class="form-inline" style="margin-top: 10px;">
                    <div class="form-group">
                        <select name="category" class="form-control" style="border-radius: 20px; border: 1px solid var(--primary-green);">
                            <option value="">-- Tất cả danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['category_id'] ?>" <?= (isset($selectedCategory) && $selectedCategory == $cat['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background: var(--primary-green); border: none; border-radius: 20px; margin-left: 10px;">
                        <i class="fa fa-filter"></i> Lọc
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
            <div class="col-md-3 col-sm-6">
                <div class="book-card" style="height: 100%;">
                    <div class="book-img-wrapper">
                        <a href="/books/show/<?= $book['book_id'] ?>">
                            <img src="<?= htmlspecialchars($book['image_url'] ?? '/images/books/default.jpg') ?>" 
                                 class="book-img" 
                                 alt="<?= htmlspecialchars($book['title']) ?>"
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
                            <i class="fa fa-user" style="color: #999;"></i> <?= htmlspecialchars($book['author']) ?>
                        </p>
                        
                        <div style="margin-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <span class="book-availability" style="<?= ($book['available_copies'] ?? 0) > 0 ? '' : 'color: #e74c3c; background: #fadbd8;' ?>">
                                <?= ($book['available_copies'] ?? 0) > 0 ? 'Có sẵn' : 'Hết sách' ?>
                            </span>
                            
                            <?php if(isset($book['category_name'])): ?>
                            <small style="color: #7f8c8d;"><?= htmlspecialchars($book['category_name']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12 text-center" style="padding: 50px;">
                <img src="/images/empty-state.png" alt="" style="width: 100px; opacity: 0.5; margin-bottom: 20px;">
                <h3 style="color: #7f8c8d;">Không tìm thấy cuốn sách nào.</h3>
                <a href="/books" class="btn btn-default" style="margin-top: 10px;">Xóa bộ lọc</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../../layouts/footer.php'; ?>