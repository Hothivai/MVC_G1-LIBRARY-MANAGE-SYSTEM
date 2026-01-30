<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Member Management | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>

<body>
<div class="d-flex">

    <!-- SIDEBAR -->
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
                    <i class="bi bi-book me-2"></i> Book Management
                </a>
            </li>

            <li class="nav-item <?= $active === 'users' ? 'active' : '' ?>">
                <a href="/admin/users/index">
                    <i class="bi bi-people me-2"></i> Member Management
                </a>
            </li>

            <li class="nav-item <?= $active === 'borrow_requests' ? 'active' : '' ?>">
                <a href="/admin/requests/index">
                    <i class="bi bi-inbox me-2"></i> Borrow Requests
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

    <!-- RIGHT CONTENT -->
    <div class="flex-grow-1">

        <!-- TOP HEADER -->
        <header class="d-flex justify-content-between align-items-center px-4"
                style="height:60px; background-color:#0f5132; color:white;">
            <h6 class="mb-0">Member Management</h6>
            <div class="d-flex align-items-center gap-2">
                <span>Admin</span>
                <i class="bi bi-person-circle fs-5"></i>
            </div>
        </header>

        <!-- MAIN -->
        <main class="p-4">

            <h6 class="mb-4">Member list</h6>

            <!-- SEARCH + FILTER + ADD -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-3">
                    <div class="input-group" style="width:220px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Search members">
                    </div>

                    <select class="form-select" style="width:150px;">
                        <option value="">All status</option>
                        <option value="active">Active</option>
                        <option value="locked">Locked</option>
                    </select>
                </div>

                <a href="/admin/users/create" class="btn btn-outline-dark">
                    <i class="bi bi-plus-lg"></i> ADD MEMBER
                </a>
            </div>

            <!-- TABLE -->
            <table class="table table-bordered align-middle">
                <thead class="table-success text-center">
                <tr>
                    <th>Member ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Join Date</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="/admin/users/edit?id=<?= $user['id'] ?>"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Không có user nào
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </main>
    </div>
</div>
</body>
</html>
