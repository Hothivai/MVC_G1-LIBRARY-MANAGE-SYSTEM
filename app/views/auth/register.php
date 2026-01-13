<!-- <?php ?>
<?php include '../app/views/layouts/header.php'; ?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/public/css/Register.css">
</head>
<body>
<section class="register">
    <img src="/public/images/logo.jpg" alt="Library Logo" class="logo">
    <h5>LIBRARY MANAGEMENT SYSTEM</h5>
    <form method="POST" action="/controller/authController.php">
    <div class="mb-3 mt-3">
      <label for="fullname" class="form-label">Fullname</label>
      <input type="text" class="form-control" id="fullname" placeholder="Enter fullname" name="fullname">
    </div>
    <div class="mb-3 mt-3">
      <label for="phone" class="form-label">Phone</label>
      <input type="tel" class="form-control" id="phone" placeholder="Enter phone number" name="phone" required>
    </div>
    <div class="mb-3 mt-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email address" name="email" required>
    </div>
    <div class="row mb-3 mt-3">
      <div class="col">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
      </div>
      <div class="col">
        <label for="confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm_password" placeholder="Confirm password" name="confirm_password" required>
      </div>
    </div>

        <button type="submit" class="btn">REGISTER</button>
    </div>
    </form>
    <p> Already have an account? <a href="/login">Login</a></p>
</section>
<!-- <?php include '../app/views/layouts/footer.php'; ?> -->

</body>
</html>