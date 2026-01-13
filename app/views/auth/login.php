<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/public/css/login.css">
</head>

<body>
    <?php include './app/views/layouts/header.php'; ?>
    <div class="container mt-3">
        <img src="/public/images/logo.png" alt="Library logo" class="logo">
        <h5>LIBRARY MANAGEMENT SYSTEM</h5>
        <form action="/action_page.php">
            <div class="mb-3 mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
            </div>
            <div class="mb-3">
                <label for="pwd">Password</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
            </div>
            <button type="submit" class="btn">LOG IN</button>
            <div class="register mt-3">
                <label for="text">Don't have an account?</label>
                <a href="./register.php" class="register-link">Register now</a>
            </div>
        </form>
    </div>

    <?php include './app/views/layouts/footer.php'; ?>

</body>
</html>