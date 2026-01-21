
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/login.css">

</head>

<body>
<div class="container">
    <div class="text-center mb-4">
        <img src="/public/images/logo.jpg" class="logo">
        <h5 class="fw-bold">LIBRARY MANAGEMENT SYSTEM</h5>
    </div>

    <form action="/auth/login" method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control"
                   placeholder="Enter email"
                   name="email" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control"
                   placeholder="Enter password"
                   name="password" required>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <button class="btn btn-primary w-100">LOG IN</button>

        <div class="text-center mt-3">
            Don't have an account?
            <a href="/register">Register now</a>
        </div>
    </form>
</div>
</body>
</html>