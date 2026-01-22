<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="modal fade" id="editProfileModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="/public/user/profile/update" method="post">

        <div class="modal-body text-center">

          <!-- Avatar -->
          <?php
            $initials = '';
            if (!empty($user['full_name'])) {
                foreach (explode(' ', $user['full_name']) as $w) {
                    $initials .= strtoupper(mb_substr($w, 0, 1));
                }
            }
          ?>

          <div class="rounded-circle bg-secondary text-white fw-bold d-inline-flex
                      align-items-center justify-content-center mb-2"
               style="width:80px;height:80px;font-size:28px;">
              <?= $initials ?>
          </div>

          <!-- <h5 class="fw-bold mb-0"><?= htmlspecialchars($user['full_name']) ?></h5>
          <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small> -->

          <div class="mt-4 text-start">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text"
                     class="form-control"
                     name="full_name"
                     value="<?= htmlspecialchars($user['full_name']) ?>"
                     required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text"
                     class="form-control"
                     name="phone"
                     value="<?= htmlspecialchars($user['phone']) ?>"
                     required>
            </div>
                <div class="mb-3">
              <label class="form-label">Address</label>
              <input type="text"
                     class="form-control"
                     name="address"
                     value="<?= htmlspecialchars($user['address']) ?>"
                     required>
            </div>
          </div>
        </div>

        <div class="modal-footer d-flex gap-3">
          <button type="button"
                  class="btn btn-success flex-fill"
                  data-bs-dismiss="modal">
              Hủy
          </button>
          <button type="submit"
                  class="btn btn-success flex-fill">
              Update
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
