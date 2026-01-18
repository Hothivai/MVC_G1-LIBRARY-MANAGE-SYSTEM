<?php
// Lấy URL hiện tại để xử lý Active State
$current_uri = $_SERVER['REQUEST_URI'] ?? '/';

// Hàm kiểm tra active đơn giản
function isActive($uri, $keyword) {
    if ($keyword == '/' && ($uri == '/' || $uri == '/index.php')) return 'active';
    if ($keyword != '/' && strpos((string)$uri, $keyword) !== false) return 'active';
    return '';
}
?>
<html>
    <link rel="stylesheet" href="/public/css/style.css">
<header class="main-header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/public/images/logo.jpg" alt="TMV Library">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav" style="float: none; display: inline-block; left: 50%; transform: translateX(-50%); position: absolute;">
                    <li class="<?= isActive($current_uri, '/') ?>">
                        <a href="/app/views/home/index.php">Home</a>
                    </li>
                    
                    <li class="<?= isActive($current_uri, '/books') ?>">
                        <a href="/app/views/user/books/index.php">Books</a>
                    </li>

                    <li class="<?= isActive($current_uri, '/about') ?>">
                        <a href="/app/views/home/about.php">About</a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="/app/views/notifications/index.php" style="border:none; font-size: 20px;">
                                <i class="fa fa-bell"></i>
                            </a>
                        </li>
                        <li class="dropdown user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="border:none; display: flex; align-items: center;">
                                <div style="width: 35px; height: 35px; background: #ccc; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 10px;">
                                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/app/views/user/profile/index.php">Hồ sơ</a></li>
                                <li><a href="/app/views/auth/login.php">Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/app/views/auth/register.php" class="btn-nav-action">Register</a></li>
                        <li><a href="/app/views/auth/login.php" class="btn-nav-action">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
</html>