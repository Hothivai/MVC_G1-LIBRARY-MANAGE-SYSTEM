<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<form action="/profile/update" method="POST" class="mb-5">
    <h4>Edit Information</h4>
    <div class="mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?= $user['full_name'] ?>">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">
    </div>
    <button type="submit" class="btn btn-success">Save Changes</button>
</form>

<hr>

<form action="/profile/change-password" method="POST">
    <h4>Change Password</h4>
    <div class="mb-3">
        <label>Current Password</label>
        <input type="password" name="old_password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>New Password</label>
        <input type="password" name="new_password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-danger">Update Password</button>
</form>

<?php include '../app/views/layouts/footer.php'; ?>
