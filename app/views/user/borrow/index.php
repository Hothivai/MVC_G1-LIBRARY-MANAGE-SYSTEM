<?php
require_once dirname(__DIR__, 2) . '/layouts/header.php';
require_once dirname(__DIR__, 2) . '/layouts/navbar.php';
?>

<div class="container mt-4 mb-5">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-book-half me-2"></i> My Borrow History
    </h3>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Book Title</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php foreach ($transactions as $index => $t): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <strong><?= htmlspecialchars($t['book_title']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($t['author']) ?></small>
                                </td>

                                <td><?= date('d/m/Y', strtotime($t['borrow_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($t['due_date'])) ?></td>

                                <td>
                                    <?php if ($t['status'] === 'borrow'): ?>
                                        <span class="badge bg-warning text-dark">Borrowing</span>
                                    <?php elseif ($t['status'] === 'returned'): ?>
                                        <span class="badge bg-success">Returned</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Unknown</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                You have no borrow history.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require_once dirname(__DIR__, 2) . '/layouts/footer.php'; ?>