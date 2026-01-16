
 <?php 
if (session_status() == PHP_SESSION_NONE) session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/MVC_G1-LIBRARY-MANAGE-SYSTEM/public/css/Register.css">
</head>
<body>
<body>
<section class="register">
   <img src="/MVC_G1-LIBRARY-MANAGE-SYSTEM/public/images/logo.jpg" alt="Library Logo" class="logo">
    <h5>LIBRARY MANAGEMENT SYSTEM</h5>

    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger shadow-sm">
            <ul class="mb-0">
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form method="POST" action="/MVC_G1-LIBRARY-MANAGE-SYSTEM/auth/register">
        <div class="mb-3 mt-3">
          <label for="fullname" class="form-label">Fullname</label>
          <input type="text" class="form-control" name="fullname" 
                 value="<?= $_SESSION['old_data']['fullname'] ?? '' ?>" placeholder="Enter fullname">
        </div>
        
        <div class="mb-3 mt-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="tel" class="form-control" name="phone" 
                 value="<?= $_SESSION['old_data']['phone'] ?? '' ?>" placeholder="Enter phone number" required>
        </div>

        <div class="mb-3 mt-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" name="email" 
                 value="<?= $_SESSION['old_data']['email'] ?? '' ?>" placeholder="Enter email address" required>
        </div>

        <div class="row mb-3 mt-3">
          <div class="col">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
          </div>
          <div class="col">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm password" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">REGISTER</button>
    </form>
    
    <?php unset($_SESSION['old_data']); // Xóa dữ liệu cũ sau khi hiện ?>
    
    <p class="mt-3 text-center"> Already have an account? <a href="/login">Login</a></p>
</section>
</body>
</body>
</html>