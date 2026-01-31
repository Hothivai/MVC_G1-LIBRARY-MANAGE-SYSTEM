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
                <form method="GET" action="index.php" class="d-flex gap-3">
                    <input type="hidden" name="action" value="admin_users_index">
                    
                    <div class="input-group" style="width:220px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="search" 
                               placeholder="Search members"
                               value="<?= htmlspecialchars($search ?? '') ?>">
                    </div>

                    <select class="form-select" name="status" style="width:150px;" onchange="this.form.submit()">
                        <option value="">All status</option>
                        <option value="active" <?= (isset($status_filter) && $status_filter === 'active') ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= (isset($status_filter) && $status_filter === 'inactive') ? 'selected' : '' ?>>Inactive</option>
                    </select>
                    
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                    
                    <?php if (!empty($search) || !empty($status_filter)): ?>
                        <a href="index.php?action=admin_users_index" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> Clear
                        </a>
                    <?php endif; ?>
                </form>

                <a href="index.php?action=admin_users_create" class="btn btn-outline-dark">
                    <i class="bi bi-plus-lg"></i> ADD MEMBER
                </a>
            </div>

            <!-- TABLE -->
            <table class="table table-bordered align-middle">
                <thead class="table-success text-center">
                <tr>
                    <!-- <th width="60">Avatar</th> -->
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
                        <?php 
                        // Safety check: bỏ qua admin users nếu có
                        if (isset($user['role']) && ($user['role'] === 'admin' || $user['role'] === 'Admin')) {
                            continue;
                        }
                        ?>
                        <tr>
                            
                            <td><?= htmlspecialchars($user['user_id']) ?></td>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                            <td><?= !empty($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : '' ?></td>
                            <td class="text-center">
                                <span class="badge bg-<?= $user['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="index.php?action=admin_users_edit&id=<?= $user['user_id'] ?>"
                                   class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Không có member nào
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
