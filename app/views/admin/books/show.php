<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
    <style>
        .book-detail-cover {
            width: 100%;
            height: 400px;
            object-fit: contain; /* Hiển thị trọn vẹn ảnh */
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f9fa;
            padding: 5px;
        }
        .info-label {
            font-weight: bold;
            min-width: 140px;
            display: inline-block;
            color: #333;
        }
        .btn-action {
            border: 1px solid #333;
            color: #333;
            font-weight: 600;
            padding: 8px 20px;
            text-transform: uppercase;
            font-size: 0.9rem;
            background: white;
            transition: 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .btn-action:hover {
            background: #f0f0f0;
            color: #333;
        }
        .section-header {
            border-bottom: 2px solid #22c55e;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        /* Table Style */
        .table-custom thead {
            background-color: #22c55e;
            color: white;
        }
        .table-custom th {
            font-weight: 500;
            border: none;
            padding: 12px;
        }
        .table-custom td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <?php require_once APP_PATH . '/views/admin/sidebarAdmin.php'; ?>

    <div class="main-content flex-grow-1">
        <nav class="navbar navbar-light bg-white px-4">
            <span class="navbar-brand fw-bold">Book Details</span>
            <div class="d-flex align-items-center">
                <span class="me-2 fw-bold">Admin</span>
                <i class="bi bi-person-circle fs-3"></i>
            </div>
        </nav>

        <div class="p-4">
            <div class="mb-4" style="border-top: 3px solid #22c55e;"></div>

            <div class="row g-5">
                <div class="col-md-4">
                    <img src="../../../public/<?= htmlspecialchars($book['cover_image'] ?? 'images/books/1984.jpg') ?>" 
                         class="book-detail-cover" 
                         alt="<?= htmlspecialchars($book['title']) ?>"
                         onerror="this.src='../../../public/images/books/1984.jpg'">
                    <div class="border rounded p-3 mt-3 text-center">
                        <div class="mb-1">Category: <strong><?= htmlspecialchars($book['category_name']) ?></strong></div>
                        <div class="text-success fw-bold">Status: In Stock</div>
                    </div>
                </div>

                <div class="col-md-8">
                    <h2 class="fw-bold mb-1"><?= htmlspecialchars($book['title']) ?></h2>
                    <p class="text-muted mb-4">by <?= htmlspecialchars($book['author']) ?></p>

                    <div class="mb-2"><span class="info-label">ISBN:</span> <?= htmlspecialchars($book['isbn']) ?></div>
                    <div class="mb-2"><span class="info-label">Publisher:</span> <?= htmlspecialchars($book['publisher'] ?? 'N/A') ?></div>
                    <div class="mb-2"><span class="info-label">Publication Year:</span> <?= htmlspecialchars($book['published_year'] ?? 'N/A') ?></div>
                    <div class="mb-2"><span class="info-label">Category:</span> <?= htmlspecialchars($book['category_name']) ?></div>
                    <div class="mb-4"><span class="info-label">Status:</span> <?= $book['available_copies'] ?>/<?= $book['total_copies'] ?? 0 ?> copies available</div>

                    <div class="mb-4">
                        <strong>Description:</strong>
                        <p class="text-muted mt-2" style="text-align: justify;">
                            <?= nl2br(htmlspecialchars($book['description'])) ?>
                        </p>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <a href="index.php?action=admin_books_edit&id=<?= $book['book_id'] ?>" class="btn btn-action">
                            <i class="bi bi-pencil-fill me-2"></i> EDIT
                        </a>
                        <button class="btn btn-action">
                            <i class="bi bi-clock-history me-2"></i> BORROWING HISTORY
                        </button>
                        <button class="btn btn-action text-danger" onclick="confirmDelete(<?= $book['book_id'] ?>)">
                            <i class="bi bi-trash-fill me-2"></i> DELETE
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h4 class="fw-bold mb-4">
                    <i class="bi bi-clock-history text-primary me-2"></i> Borrowing History
                </h4>
                
                <div class="table-responsive">
                    <table class="table table-custom w-100">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($history)): ?>
                                <?php foreach ($history as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['member_name']) ?> (<?= $row['member_code'] ?? 'MEM' ?>)</td>
                                    <td><?= date('d/m/Y', strtotime($row['borrow_date'])) ?></td>
                                    <td><?= $row['return_date'] ? date('d/m/Y', strtotime($row['return_date'])) : '-' ?></td>
                                    <td>
                                        <?php if($row['status'] == 'returned'): ?>
                                            <span class="text-success">Returned</span>
                                        <?php elseif($row['status'] == 'borrowing'): ?>
                                            <span class="text-warning fw-bold">Borrowing</span>
                                        <?php else: ?>
                                            <span class="text-danger">Overdue</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td>Nguyen Van A (MEM001)</td>
                                    <td>15/12/2024</td>
                                    <td>20/12/2024</td>
                                    <td class="text-success">Returned</td>
                                </tr>
                                <tr>
                                    <td>Tran Thi B (MEM002)</td>
                                    <td>20/12/2024</td>
                                    <td>-</td>
                                    <td class="text-warning fw-bold">Borrowing</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    if(confirm('Are you sure you want to delete this book?')) {
        window.location.href = 'index.php?action=admin_books_delete&id=' + id;
    }
}
</script>
</body>
</html>