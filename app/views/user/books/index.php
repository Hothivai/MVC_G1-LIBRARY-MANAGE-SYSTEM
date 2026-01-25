<?php 
// Nạp các thành phần layout dùng chung
require_once dirname(__DIR__, 2) . '/layouts/header.php';
require_once dirname(__DIR__, 2) . '/layouts/navbar.php';
?>

<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <div class="row">
        <aside class="col-md-3">
            <div class="filter-section shadow-sm p-4 bg-white rounded border-top border-success border-4">
                <h4 class="fw-bold mb-4 text-success"><i class="fa fa-filter me-2"></i>Bộ lọc</h4>
                
                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="home"> <div class="mb-4">
                        <label class="fw-bold mb-2">Danh mục</label>
                        <?php 
                        $cats = ['Công nghệ', 'Khoa học', 'Văn học', 'Kinh tế', 'Tự phát triển', 'Tâm lý học'];
                        foreach($cats as $cat): ?>
                            <div class="form-check mb-1">
                                <input class="form-check-input accent-success" type="checkbox" name="cat[]" value="<?= $cat ?>">
                                <label class="form-check-label small"><?= $cat ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold mb-2">Trạng thái</label>
                        <div class="form-check mb-1">
                            <input class="form-check-input accent-success" type="checkbox" checked>
                            <label class="form-check-label small text-success fw-bold">Có sẵn</label>
                        </div>
                        <div class="form-check mb-1">
                            <input class="form-check-input accent-success" type="checkbox">
                            <label class="form-check-label small">Đang mượn</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="background-color: #16A34A; border: none;">
                        Áp dụng bộ lọc
                    </button>
                    <a href="index.php?action=home" class="btn btn-link w-100 mt-2 text-decoration-none text-muted small">Xóa bộ lọc</a>
                </form>
            </div>
        </aside>

        <main class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded">
                <div class="input-group w-50">
                    <input type="text" class="form-control border-success" placeholder="Tìm kiếm sách...">
                    <button class="btn btn-success" type="button" style="background-color: #16A34A;"><i class="fa fa-search"></i></button>
                </div>
                <div class="d-flex align-items-center">
                    <label class="me-2 small text-muted">Sắp xếp:</label>
                    <select class="form-select form-select-sm border-success">
                        <option>Mới nhất</option>
                        <option>Cũ nhất</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                <?php if(!empty($latestBooks)): ?>
                    <?php foreach($latestBooks as $book): ?>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm book-card-hover">
                            <div class="position-relative overflow-hidden" style="height: 280px;">
                                <img src="<?= !empty($book['image_url']) ? $book['image_url'] : '/public/images/books/1984.jpg' ?>" 
                                     class="card-img-top h-100 w-100 object-fit-cover" alt="Book Cover">
                                
                                <?php if(($book['available_copies'] ?? 0) > 0): ?>
                                    <span class="badge bg-success position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm">Có sẵn</span>
                                <?php else: ?>
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm">Hết sách</span>
                                <?php endif; ?>
                            </div>

                            <div class="card-body p-3">
                                <p class="text-muted small mb-1"><?= htmlspecialchars($book['category_name'] ?? 'Chưa phân loại') ?></p>
                                <h6 class="card-title fw-bold text-dark mb-1 line-clamp-2"><?= htmlspecialchars($book['title']) ?></h6>
                                <p class="card-text small text-secondary mb-3">by <?= htmlspecialchars($book['author']) ?></p>
                                
                                <div class="d-flex gap-2">
                                    <a href="index.php?action=book_detail&id=<?= $book['book_id'] ?>" class="btn btn-outline-success btn-sm flex-grow-1 border-2 fw-bold">Chi tiết</a>
                                    <?php if(($book['available_copies'] ?? 0) > 0): ?>
                                        <a href="index.php?action=borrow_request&id=<?= $book['book_id'] ?>" class="btn btn-success btn-sm flex-grow-1 fw-bold" style="background-color: #16A34A;">Mượn sách</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fa fa-book fa-3x text-light-green mb-3"></i>
                        <p class="text-muted">Không tìm thấy sách nào phù hợp.</p>
                    </div>
                <?php endif; ?>
            </div>

            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link text-success" href="#">Trước</a></li>
                    <li class="page-item active"><a class="page-link bg-success border-success" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-success" href="#">Sau</a></li>
                </ul>
            </nav>
        </main>
    </div>
</div>

<style>
/* Custom CSS để đồng bộ màu xanh lá cây của dự án */
:root {
    --primary-green: #2ecc71;
    --dark-green: #145c38;
}

.accent-success {
    accent-color: #16A34A;
}

.book-card-hover {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.book-card-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pagination .page-link {
    color: #16A34A;
    border-radius: 8px;
    margin: 0 3px;
}

.bg-success {
    background-color: #16A34A !important;
}

.btn-outline-success {
    color: #16A34A;
    border-color: #16A34A;
}

.btn-outline-success:hover {
    background-color: #16A34A;
    color: white;
}
</style>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>