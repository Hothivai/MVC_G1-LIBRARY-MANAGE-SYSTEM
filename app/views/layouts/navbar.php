<?php
$current_uri = $_SERVER['REQUEST_URI'] ?? '';

function isActive($uri, $action) {
    if (strpos($uri, "/$action") !== false) return 'active';
    if (strpos($uri, "action=$action") !== false) return 'active';
    if ($action === 'home' && ($uri === '/' || strpos($uri, '/index.php') === false)) return 'active';
    return '';
}
?>

<link rel="stylesheet" href="/public/css/style.css">

<header class="main-header">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">

            <!-- LOGO -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <img src="/public/images/logo.jpg" alt="TMV Library">
                </a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">

                <!-- MENU CENTER -->
                <ul class="nav navbar-nav" style="float:none; position:absolute; left:50%; transform:translateX(-50%);">
                    <li class="<?= isActive($current_uri, 'home') ?>">
                        <a href="/">Home</a>
                    </li>

                    <li class="<?= isActive($current_uri, 'books') ?>">
                        <a href="/books">Books</a>
                    </li>

                    <li class="<?= isActive($current_uri, 'about') ?>">
                        <a href="/about">About</a>
                    </li>
                </ul>

                <!-- MENU RIGHT -->
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="/notifications" style="font-size:20px;">
                                <i class="fa fa-bell"></i>
                            </a>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?= strtoupper(substr($_SESSION['user_name'] ?? 'User', 0, 1)) ?>
                                <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/profile">Profile</a></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/register">Register</a></li>
                        <li><a href="/login">Login</a></li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>
</header>
