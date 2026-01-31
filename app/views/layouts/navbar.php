
<?php
$notificationCount = 0;

// if (class_exists('Notification') && Auth::check()) {
//     $notificationModel = new Notification();
//     $notificationCount = $notificationModel->countByUser(Auth::getUserId());
// }


// Lấy action hiện tại để xử lý Active State
$current_action = $_GET['action'] ?? 'home_index';

// Hàm kiểm tra active đơn giản
function isActive($action, $keyword) {
    if ($keyword == 'home_index' && ($action == 'home_index' || strpos($action, 'home') !== false)) return 'active';
    if ($keyword != 'home_index' && strpos($action, $keyword) !== false) return 'active';
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
                <a class="navbar-brand" href="index.php?action=home_index">
                    <img src="/public/images/logo.jpg" alt="TMV Library">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav" style="float: none; display: inline-block; left: 50%; transform: translateX(-50%); position: absolute;">
                    <li class="<?= isActive($current_action, 'home_index') ?>">
                        <a href="index.php?action=home_index">Home</a>
                    </li>
                    
                    <li class="<?= isActive($current_action, 'user_books_index') ?>">
                        <a href="index.php?action=user_books_index">Books</a>
                    </li>

                    <li class="<?= isActive($current_action, 'home_about') ?>">
                        <a href="index.php?action=home_about">About</a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="index.php?controller=notification&action=index">
                                <i class="fa fa-bell"></i>


                                <?php if ($notificationCount > 0): ?>
                                    <span class="notification-badge">
                                        <?= $notificationCount ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <li class="dropdown user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="border:none; display: flex; align-items: center;">
                                <div style="width: 35px; height: 35px; background: #ccc; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 10px;">
                                    <?= strtoupper(substr($_SESSION['user']['full_name'] ?? 'U', 0, 1)) ?>
                                </div>
                                <span><?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'User') ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="index.php?action=user_profile_index">Profile</a></li>
                                <li><a href="index.php?action=auth_logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="index.php?action=auth_register" class="btn-nav-action">Register</a></li>
                        <li><a href="index.php?action=auth_login" class="btn-nav-action">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
</html>
<script src="/public/js/notification.js"></script>
