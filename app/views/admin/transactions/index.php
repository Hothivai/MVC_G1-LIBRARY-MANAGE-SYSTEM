<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transaction Management</title>
    <link rel="icon" href="/public/images/logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>

<body>
    <div class="d-flex">
        <?php require_once __DIR__ . '/../sidebarAdmin.php'; ?>

        <!-- MAIN -->
        <div class="flex-grow-1">

            <!-- NAVBAR -->
            <nav class="navbar navbar-dark bg-success px-4">
                <span class="navbar-brand">Dashboard</span>
                <div class="text-white fs-5 d-flex align-items-center gap-3">
                    <?= htmlspecialchars($admin['name'] ?? 'Admin') ?>
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                </div>
            </nav>

            <!-- CONTENT -->
            <main class="p-4">
                <h5>Transaction Management</h5>
                <table class="table table-bordered align-middle mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td><?= $t['transaction_id'] ?></td>
                                    <td><?= htmlspecialchars($t['member_name']) ?></td>
                                    <td><?= htmlspecialchars($t['book_title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($t['borrow_date'])) ?></td>
                                    <td class="text-center"><?= $t['due_date'] ?></td>
                                    <td>
                                        <?php
                                        $status = strtolower($t['status']);
                                        $badgeClass = 'bg-info'; // Mặc định cho borrowed
                                        if ($status === 'returned') $badgeClass = 'bg-success';
                                        if ($status === 'overdue') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($status === 'borrowed' || $status === 'overdue'): ?>
                                            <form method="POST" action="index.php?action=admin_transactions_approve">
                                                <input type="hidden" name="transaction_id" value="<?= $t['transaction_id'] ?>">
                                                <button type="submit" class="btn btn-success btn-sm px-3"
                                                    onclick="return confirm('Confirm book return?')">
                                                    <i class="bi bi-arrow-return-left"></i> Return
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-light btn-sm text-muted border" disabled>
                                                <i class="bi bi-check-all"></i> Returned
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No transactions found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/js/admin.js"></script>
</body>

</html>