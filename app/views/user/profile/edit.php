<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/login.css">

    <style>
        .profile-card {
            max-width: 450px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #adb5bd;
            color: white;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }
    </style>
</head>

<body>
<div class="profile-card text-center">

    <?php
        // Lấy chữ cái đầu của tên
        $initials = '';
        if (!empty($user['full_name'])) {
            $words = explode(' ', $user['full_name']);
            foreach ($words as $w) {
                $initials .= strtoupper(mb_substr($w, 0, 1));
            }
        }
    ?>

    <!-- Avatar -->
    <div class="avatar">
        <?= $initials ?>
    </div>

    <!-- Name & Email -->
    <h5 class="fw-bold mb-0"><?= htmlspecialchars($user['full_name']) ?></h5>
    <small class="text-muted"><?= htmlspecialchars($user['email'] ?? '') ?></small>

    <form action="/public/user/profile/update" method="post" class="mt-4 text-start">

        <div class="mb-3">
            <label class="fw-semibold">Full Name</label>
            <input type="text"
                   class="form-control"
                   name="full_name"
                   value="<?= htmlspecialchars($user['full_name']) ?>"
                   required>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">Phone</label>
            <input type="text"
                   class="form-control"
                   name="phone"
                   value="<?= htmlspecialchars($user['phone']) ?>"
                   required>
        </div>

 <div class="d-flex gap-3 mt-4">
    <a href="/public/user/profile" class="btn btn-success flex-fill">
        Hủy
    </a>
    <button type="submit" class="btn btn-success flex-fill">
        Update
    </button>
</div>
    </form>
</div>
</body>
</html>
