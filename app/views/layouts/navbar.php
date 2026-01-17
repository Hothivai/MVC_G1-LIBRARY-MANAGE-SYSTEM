<?php
use App\Models\Category;
$categoryModel = new Category();
$menuCategories = $categoryModel->all();
$currentKeyword = $_GET['q'] ?? '';
?>

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
                    <img src="/images/logo.png" alt="Thư Viện" class="logo-img">
                    <span>Thư Viện Số</span>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="main-navbar">
                <ul class="nav navbar-nav">
                    <li class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>">
                        <a href="/">Trang chủ</a>
                    </li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Danh mục sách <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($menuCategories as $category): ?>
                                <li>
                                    <a href="/books/search?category=<?= $category['category_id'] ?>">
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/user/books">Danh sách sách</a></li>
                    <li><a href="/user/borrow">Sách đang mượn</a></li>
                    <?php endif; ?>

                    <li><a href="/about">Giới thiệu</a></li>
                </ul>

                <form class="navbar-form navbar-left" action="/books/search" method="GET" role="search">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control search-input" 
                               placeholder="Tìm sách, tác giả..." value="<?= htmlspecialchars($currentKeyword) ?>" required>
                        <div class="input-group-btn">
                            <button class="btn btn-default search-btn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                            <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <?php endif; ?>
                        
                        <li class="dropdown user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user-circle"></i> 
                                <?= htmlspecialchars($_SESSION['user_name']) ?> 
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/user/profile"><i class="fa fa-user"></i> Trang cá nhân</a></li>
                                <li><a href="/user/notifications">
                                    <i class="fa fa-bell"></i> Thông báo
                                    <?php if (isset($unreadCount) && $unreadCount > 0): ?>
                                    <span class="badge badge-danger"><?= $unreadCount ?></span>
                                    <?php endif; ?>
                                </a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="/logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="/login"><i class="fa fa-sign-in"></i> Đăng nhập</a></li>
                        <li><a href="/register"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="header-spacer"></div>