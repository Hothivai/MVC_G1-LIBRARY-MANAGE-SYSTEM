<?php ?>
<nav class="navbar">
    <div class="navbar-brand">
        <h1>Thư Viện Quận</h1>
    </div>
    <ul class="navbar-menu">
        <li><a href="/">Trang Chủ</a></li>
        <li><a href="/about">Giới Thiệu</a></li>
        <li><a href="/books">Sách</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="/profile">Hồ Sơ</a></li>
            <li><a href="/logout">Đăng Xuất</a></li>
        <?php else: ?>
            <li><a href="/login">Đăng Nhập</a></li>
            <li><a href="/register">Đăng Ký</a></li>
        <?php endif; ?>
    </ul>
</nav>
