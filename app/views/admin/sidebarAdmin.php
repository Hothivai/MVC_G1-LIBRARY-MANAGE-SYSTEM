<aside class="sidebar p-3">
    <div class="text-center mb-4">
        <img src="/public/images/logo.jpg" class="logo">
        <h5 class="mt-2">ADMIN PANEL</h5>
    </div>


    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>"
               href="index.php?action=admin_dashboard_index">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $active === 'books' ? 'active' : '' ?>"
               href="index.php?action=admin_books_index">
                <i class="bi bi-book me-2"></i> Book Management
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $active === 'users' ? 'active' : '' ?>"
               href="index.php?action=admin_users_index">
                <i class="bi bi-people me-2"></i> Member Management
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $active === 'requests' ? 'active' : '' ?>"
               href="index.php?action=admin_requests">
                <i class="bi bi-journal-text me-2"></i> Borrow Requests
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $active === 'transactions' ? 'active' : '' ?>"
               href="index.php?action=admin_transactions_index">
                <i class="bi bi-arrow-left-right me-2"></i> Transactions
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link <?= $active === 'categories' ? 'active' : '' ?>"
               href="index.php?action=admin_categories_index">
                <i class="bi bi-tags me-2"></i> Categories
            </a>
        </li>


        <li class="nav-item mt-3">
            <a class="nav-link text-danger" href="index.php?action=auth_logout">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </li>
    </ul>
</aside>
