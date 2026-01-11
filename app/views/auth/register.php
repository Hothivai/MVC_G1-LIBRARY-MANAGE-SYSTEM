<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="register">
    <h1>Đăng Ký Tài Khoản</h1>
    <form method="POST" action="/register">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật Khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Ký</button>
    </form>
    <p>Đã có tài khoản? <a href="/login">Đăng nhập tại đây</a></p>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
