<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Member | Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/admin.css">
</head>
<body>

<div class="container py-4">
    <h4 class="mb-4">Add New Member</h4>

    <form method="POST" action="index.php?action=admin_users_store">

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" name="full_name" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone">
            </div>

            <div class="col-md-6">
                <label class="form-label">Role</label>
                <select class="form-select" name="role" disabled>
                    <option value="member" selected>Member</option>
                </select>
                <input type="hidden" name="role" value="member">
                <small class="text-muted">Chỉ có thể tạo tài khoản Member</small>
            </div>

            <div class="col-12">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address"></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Save Member
            </button>

            <a href="index.php?action=admin_users_index" class="btn btn-secondary">
         Cancel
            </a>

        </div>
    </form>
</div>

</body>
</html>
