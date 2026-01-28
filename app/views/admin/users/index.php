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

                <li class="nav-item <?= $active === 'borrow_requests' ? 'active' : '' ?>">
                    <a href="index.php?action=admin_requests">
                        <i class="bi bi-people me-2"></i> Borrow Requests
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
                    <a href="index.php?action=auth_login">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </aside>
        <main class="p-4">

    <!-- TITLE -->
    <h5 class="fw-bold">Member Management</h5>
    <hr>

    <h6 class="mb-4">Member list</h6>

    <!-- SEARCH + FILTER + ADD -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-3">
            <div class="input-group" style="width: 220px;">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Search members">
            </div>

            <select class="form-select" style="width: 150px;">
                <option value="">All status</option>
                <option value="active">Active</option>
                <option value="locked">Locked</option>
            </select>
        </div>

        <a href="#" class="btn btn-outline-dark">
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
                        <a href="index.php?action=admin_users_edit&id=<?= $user['id'] ?>"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</main>

