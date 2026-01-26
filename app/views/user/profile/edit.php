<<<<<<< HEAD
=======
<!-- Modal for editing user profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="/user/updateProfile" class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
          <i class="fas fa-user-edit me-2"></i>Edit Profile
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Full name</label>
          <input type="text" name="full_name" class="form-control"
                 value="<?= htmlspecialchars($user['full_name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone number</label>
          <input type="text" name="phone" class="form-control"
                 value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <input type="text" name="address" class="form-control"
                 value="<?= htmlspecialchars($user['address'] ?? '') ?>">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Save changes</button>
      </div>

    </form>
  </div>
</div>

<!-- Modal for changing password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="/user/changePassword" class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">
          <i class="fas fa-key me-2"></i>Change Password
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Current password</label>
          <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">New password</label>
          <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Confirm new password</label>
          <input type="password" name="confirm_password" class="form-control" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-dark">Update password</button>
      </div>

    </form>
  </div>
</div>
>>>>>>> dafc32a52f62e5c8a400b867c3141f6f964a05de
