<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="login">
    <h1>Đăng Nhập</h1>
    <form method="POST" action="/login">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mật Khẩu:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>
    <p>Chưa có tài khoản? <a href="/register">Đăng ký tại đây</a></p>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
