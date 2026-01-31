<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Member | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>

<div class="container py-4">
    <h4 class="mb-4">Edit Member</h4>

    <?php if (isset($user) && ($user['role'] === 'admin' || $user['role'] === 'Admin')): ?>
        <div class="alert alert-danger">
            Cannot edit admin accounts.
        </div>
        <a href="index.php?action=admin_users_index" class="btn btn-secondary">Back to List</a>
    <?php else: ?>
        <form method="POST" action="index.php?action=admin_users_update&id=<?= $user['user_id'] ?? '' ?>">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?? '' ?>">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled>
                    <small class="text-muted">Username cannot be changed</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="full_name" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" name="address"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($user['role'] ?? 'member') ?>" disabled>
                    <small class="text-muted">Role cannot be changed</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="active" <?= ($user['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($user['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update Member
                </button>

                <a href="index.php?action=admin_users_index" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        </form>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/admin.js"></script>
</body>
</html>
