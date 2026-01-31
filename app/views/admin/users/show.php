<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Details | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>

<div class="container py-4">
    <h4 class="mb-4">Member Details</h4>

    <?php if (isset($user) && ($user['role'] === 'admin' || $user['role'] === 'Admin')): ?>
        <div class="alert alert-danger">
            Cannot view admin accounts.
        </div>
        <a href="index.php?action=admin_users_index" class="btn btn-secondary">Back to List</a>
    <?php elseif (isset($user)): ?>
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Member ID:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['user_id']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Username:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['username'] ?? '') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Full Name:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['full_name'] ?? '') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Email:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['email'] ?? '') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Phone:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['phone'] ?? '') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Address:</strong></div>
                    <div class="col-md-9"><?= htmlspecialchars($user['address'] ?? '') ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Role:</strong></div>
                    <div class="col-md-9">
                        <span class="badge bg-info"><?= htmlspecialchars($user['role'] ?? 'member') ?></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        <span class="badge bg-<?= ($user['status'] ?? '') === 'active' ? 'success' : 'secondary' ?>">
                            <?= ucfirst($user['status'] ?? 'inactive') ?>
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Join Date:</strong></div>
                    <div class="col-md-9">
                        <?= !empty($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : '' ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php?action=admin_users_edit&id=<?= $user['user_id'] ?>" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="index.php?action=admin_users_index" class="btn btn-secondary">
                    Back to List
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Member not found.
        </div>
        <a href="index.php?action=admin_users_index" class="btn btn-secondary">Back to List</a>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
