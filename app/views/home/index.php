<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <body>
        
<?php include '../app/views/layouts/header.php'; ?>
<header>
    <?php if ($user): ?>
        <!-- ĐÃ ĐĂNG NHẬP -->
        <div class="user-info">
            <i class="bi bi-person-circle fs-4 me-2"></i>
            <span><?= htmlspecialchars($user['full_name']) ?></span>
        </div>
    <?php else: ?>
        <!-- CHƯA ĐĂNG NHẬP -->
        <a href="/auth/login">Login</a>
        <a href="/auth/register">Register</a>
    <?php endif; ?>
</header>

<main>
    <h1>Welcome to Library Management System</h1>
</main>
<?php include '../app/views/layouts/footer.php'; ?>

</body>
</html>
