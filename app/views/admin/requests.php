<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Borrow Requests</title>
    <link rel="icon" href="/public/images/logo.jpg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>


<body>
    <div class="d-flex">


        <?php require_once __DIR__ . '/sidebarAdmin.php'; ?>


        <!-- MAIN -->
        <div class="flex-grow-1">


            <!-- NAVBAR -->
            <nav class="navbar navbar-dark bg-success px-4">
                <span class="navbar-brand">Borrow Requests</span>
                <div class="text-white fs-5 d-flex align-items-center gap-3">
                    <?= htmlspecialchars($admin['name'] ?? 'Admin') ?>
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                </div>
            </nav>


            <!-- CONTENT -->
            <main class="p-4">
                <!-- HEADER -->
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h3 class="fw-bold mb-0">Manage Requests</h3>

                    <div class="bg-white p-2 px-3 rounded shadow-sm border-start border-warning border-4">
                        <div class="stat-small text-uppercase">Total Requests</div>
                        <div class="h5 fw-bold mb-0 text-warning">
                            <?= count($pendingRequests) ?>
                        </div>
                    </div>
                </div>

                <!-- REQUEST TABLE -->
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Request Date</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($pendingRequests)): ?>
                            <?php $i = 1; ?>
                            <?php foreach ($pendingRequests as $request): ?>
                                <tr>
                                    <td><?= $i++ ?></td>

                                    <td>
                                        <strong><?= htmlspecialchars($request['full_name']) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($request['email']) ?></small>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($request['book_title']) ?><br>
                                    </td>

                                    <td>
                                        <?= date('d/m/Y', strtotime($request['request_date'])) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($request['note'] ?: '—') ?>
                                    </td>

                                    <td>
                                        <?php
                                        // Đổi màu Badge theo trạng thái
                                        $status = strtolower($request['status']);
                                        $badgeClass = 'bg-warning text-dark'; // Pending
                                        if ($status === 'approved') $badgeClass = 'bg-success';
                                        if ($status === 'rejected') $badgeClass = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($status === 'pending'): ?>
                                            <form method="POST" action="index.php?action=admin_requests_approve" class="d-inline">
                                                <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">
                                                <button type="submit" class="btn btn-success btn-sm px-3"
                                                    onclick="return confirm('Approve this request?')">
                                                    Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="index.php?action=admin_requests_reject" class="d-inline ms-1">
                                                <input type="hidden" name="request_id" value="<?= $request['request_id'] ?>">
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-3"
                                                    onclick="return confirm('Reject this request?')">
                                                    Reject
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-light btn-sm text-muted border" disabled>
                                                <i class="bi bi-check2-all"></i> Processed
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No requests found.
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