<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Borrow Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>
    <form action="index.php?action=admin_requests" method="GET">
    <div class="d-flex">
        <aside class="sidebar p-3 border-end">
            <div class="text-center mb-4">
                <img src="/public/images/logo.jpg" class="logo" style="width: 60px;">
                <h6 class="mt-2 fw-bold">ADMIN PANEL</h6>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="/admin/dashboard/index"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                <li class="nav-item"><a href="/admin/books/index"><i class="bi bi-book me-2"></i> Book Management</a></li>
                <li class="nav-item"><a href="/admin/users/index"><i class="bi bi-people me-2"></i> Member Management</a></li>
                <li class="nav-item active"><a href="/admin/borrow_requests/index"><i class="bi bi-arrow-left-right me-2"></i> Borrow Requests</a></li>
                <li class="nav-item"><a href="/admin/transactions/index"><i class="bi bi-arrow-left-right me-2"></i> Transactions</a></li>
                <li class="nav-item"><a href="/admin/categories/index"><i class="bi bi-tags me-2"></i> Categories</a></li>
                <li class="nav-item mt-5"><a href="/auth/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
            </ul>
        </aside>

        <div class="flex-grow-1 bg-light">
            <nav class="navbar navbar-dark bg-dark-green px-4 shadow-sm">
                <span class="navbar-brand fw-bold">Admin Panel</span>
                <div class="text-white d-flex align-items-center gap-3">
                    <span>Admin</span>
                    <i class="bi bi-person-circle fs-4"></i>
                </div>
            </nav>
            <main class="p-4">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h3 class="fw-bold mb-0">Borrow Requests</h3>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="bg-white p-2 px-3 rounded shadow-sm border-start border-warning border-4">
                            <div class="stat-small text-uppercase">Pending</div>
                            <div class="h5 fw-bold mb-0 text-warning"><?= count($pendingRequests) ?></div>
                        </div>
                        <div class="bg-white p-2 px-3 rounded shadow-sm border-start border-success border-4">
                            <div class="stat-small text-uppercase">Total Today</div>
                            <div class="h5 fw-bold mb-0 text-success">12</div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs border-0 mb-4 bg-white p-2 rounded shadow-sm">
                    <li class="nav-item">
                        <a class="nav-link active border-0 text-success fw-bold" href="#"><i class="bi bi-clock-history me-1"></i> Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 text-muted" href="#"><i class="bi bi-check-circle me-1"></i> Approved</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 text-muted" href="#"><i class="bi bi-x-circle me-1"></i> Rejected</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-0 text-muted" href="#"><i class="bi bi-grid me-1"></i> All</a>
                    </li>
                </ul>

                <div class="request-container">
                    <?php if (!empty($pendingRequests)): ?>
                        <?php foreach ($pendingRequests as $request): ?>
                            <div class="card request-card mb-3 shadow-sm border-0">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="id-badge">#<?= $request['transaction_id'] ?></div>
                                                <div>
                                                    <h6 class="fw-bold mb-0"><i class="bi bi-book me-1"></i> <?= htmlspecialchars($request['book_title']) ?></h6>
                                                    <small class="text-muted">by <?= htmlspecialchars($request['author']) ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7 text-end">
                                            <span class="badge badge-pending px-3 py-2 rounded-pill">
                                                <i class="bi bi-hourglass-split me-1"></i> Pending
                                            </span>
                                        </div>
                                    </div>

                                    <hr class="my-3 opacity-50">

                                    <div class="row text-center">
                                        <div class="col-md-3 border-end">
                                            <div class="stat-small text-uppercase mb-1"><i class="bi bi-person me-1"></i> Member</div>
                                            <div class="fw-bold"><?= htmlspecialchars($request['member_name']) ?></div>
                                            <div class="stat-small"><?= $request['member_email'] ?></div>
                                            <?php if(isset($request['is_suspended']) && $request['is_suspended']): ?>
                                                <span class="badge bg-danger-subtle text-danger mt-1" style="font-size: 0.6rem;">SUSPENDED</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-3 border-end">
                                            <div class="stat-small text-uppercase mb-1"><i class="bi bi-calendar-check me-1"></i> Request Date</div>
                                            <div class="fw-bold"><?= date('M d, Y', strtotime($request['borrow_date'])) ?></div>
                                            <div class="stat-small"><?= date('H:i', strtotime($request['borrow_date'])) ?></div>
                                        </div>
                                        <div class="col-md-3 border-end">
                                            <div class="stat-small text-uppercase mb-1"><i class="bi bi-clock me-1"></i> Duration</div>
                                            <div class="fw-bold">14 days</div>
                                            <div class="stat-small text-danger fw-bold">Due: <?= date('M d', strtotime($request['due_date'])) ?></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-small text-uppercase mb-1"><i class="bi bi-box-seam me-1"></i> Available</div>
                                            <div class="fw-bold text-success"><?= $request['available_copies'] ?> copies</div>
                                            <div class="stat-small">In stock</div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-4">
                                            <button class="btn btn-success w-100 fw-bold">
                                                <i class="bi bi-check-lg me-1"></i> Approve Request
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-outline-danger w-100 fw-bold">
                                                <i class="bi bi-x-lg me-1"></i> Reject Request
                                            </button>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-outline-secondary w-100 fw-bold">
                                                <i class="bi bi-eye me-1"></i> View Book
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-5 bg-white rounded shadow-sm">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="mt-2 text-muted">No pending borrow requests.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
</form>
</body>
</html>