<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>

<body>
    <div class="d-flex">
        <!-- sidebar -->
        <aside class="sidebar p-3">
            <div class="text-center mb-4">
                <img src="/public/images/logo.jpg" class="logo">
                <h5 class="mt-2">ADMIN PANEL</h5>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item <?= $active === 'dashboard' ? 'active' : '' ?>">
                    <a href="/admin/dashboard/index">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item <?= $active === 'books' ? 'active' : '' ?>">
                    <a href="/admin/books/index">
                        <i class="bi bi-book  me-2"></i> Book Management
                    </a>
                </li>

                <li class="nav-item <?= $active === 'users' ? 'active' : '' ?>">
                    <a href="/admin/users/index">
                        <i class="bi bi-people me-2"></i> Member Management
                    </a>
                </li>

                <li class="nav-item <?= $active === 'transactions' ? 'active' : '' ?>">
                    <a href="/admin/transactions/index">
                        <i class="bi bi-arrow-left-right me-2"></i> Transactions
                    </a>
                </li>

                <li class="nav-item <?= $active === 'categories' ? 'active' : '' ?>">
                    <a href="/admin/categories/index">
                        <i class="bi bi-tags me-2"></i> Categories
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/auth/logout">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>

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
                <h5>SYSTEM OVERVIEW</h5>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="card text-center p-3">
                            <h5>Total Books</h5>
                            <h3 class="fw-bold"><?= $totalBooks ?></h3>
                            <div class="d-flex fs-5 justify-content-center align-items-center gap-2">
                                <i class="bi bi-book"></i>
                                <span>copies</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center p-3">
                            <h5>Borrowed</h5>
                            <h3 class="fw-bold"><?= $borrowedBooks ?></h3>
                            <div class="d-flex fs-5 justify-content-center align-items-center gap-2">
                                <i class="bi bi-arrow-repeat"></i>
                                <span>transactions</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center p-3">
                            <h5>Members</h5>
                            <h3 class="fw-bold"><?= $members ?></h3>
                            <div class="d-flex fs-5 justify-content-center align-items-center gap-2">
                                <i class="bi bi-people"></i>
                                <span>users</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-center p-3">
                            <h5>Overdue</h5>
                            <h3 class="fw-bold"><?= $overdue ?></h3>
                            <div class="d-flex fs-5 justify-content-center align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>alerts</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- recent transactions -->
                <h5 class="mt-5">
                    <i class="bi bi-arrow-repeat"></i> Recent Transactions
                </h5>
                <table class="table table-bordered align-middle mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Borrowed Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentTransactions as $row): ?>
                            <tr>
                                <td><?= $row['transaction_id'] ?></td>
                                <td><?= htmlspecialchars($row['member_name']) ?></td>
                                <td><?= htmlspecialchars($row['book_title']) ?></td>
                                <td><?= $row['borrow_date'] ?></td>
                                <td><?= $row['due_date'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['status'] === 'overdue' ? 'danger' : 'success' ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-secondary">Details</a>
                                    <a href="#" class="btn btn-sm btn-outline-success">Return</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- overdue transactions -->
                <h5 class="mt-4">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    Overdue Transactions
                </h5>
                <table class="table table-bordered align-middle mt-3">
                    <thead class="table-secondary">
                        <tr>
                            <th>Transaction ID</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Due Date</th>
                            <th>Days Overdue</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdueList as $row): ?>
                            <tr>
                                <td><?= $row['transaction_id'] ?></td>
                                <td><?= htmlspecialchars($row['member_name']) ?></td>
                                <td><?= htmlspecialchars($row['book_title']) ?></td>
                                <td><?= $row['due_date'] ?></td>
                                <td><?= $row['days_overdue'] ?> days</td>
                                <td>
                                    <span class="badge bg-danger">Overdue</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
</body>

</html>