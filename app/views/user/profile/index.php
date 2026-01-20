<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include '../app/views/layouts/header.php'; ?>

<div class="profile-container">
    <aside class="profile-sidebar">
        <div class="user-card">
            <div class="avatar-circle">NV</div>
            <h2 class="user-name"><?= $user->name ?? 'Nguyen Van' ?></h2>
            <div class="status-badge">
                <i class="fas fa-check-square"></i> Active
            </div>
        </div>

        <div class="info-card">
            <div class="info-item">
                <label><i class="fas fa-envelope"></i> Email:</label>
                <span><?= $user->email ?? 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label><i class="fas fa-phone"></i> Phone:</label>
                <span><?= $user->phone ?? 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label><i class="fas fa-map-marker-alt"></i> Address:</label>
                <span><?= $user->address ?? 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label><i class="fas fa-calendar-alt"></i> Start date:</label>
                <span><?= $user->created_at ?? 'N/A' ?></span>
            </div>
        </div>

        <div class="profile-actions">
            <a href="/profile/edit" class="btn-action">
                <i class="fas fa-edit"></i> Edit information
            </a>
            <button type="button" class="btn-action" onclick="openPasswordModal()">
                <i class="fas fa-key"></i> Change password
            </button>
        </div>
    </aside>

    <main class="profile-content">
        <div class="stats-row">
            <div class="stat-box">
                <p>Currently borrowed</p>
                <h3>3</h3>
                <a href="#">View Details</a>
            </div>
            <div class="stat-box">
                <p>Returned books</p>
                <h3>15</h3>
                <a href="#">View History</a>
            </div>
            <div class="stat-box duo-stat">
                <div class="stat-inner">
                    <p>On-time books</p>
                    <h3>15</h3>
                </div>
                <div class="stat-inner border-left">
                    <p class="text-danger">Overdue books</p>
                    <h3 class="text-danger">0</h3>
                </div>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="borrow-table">
                <thead>
                    <tr>
                        <th>Book title</th>
                        <th>Borrowed date</th>
                        <th>Return date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="book-title">PHP Fundamentals</td>
                        <td>01/12/2024</td>
                        <td class="text-success">15/12/2024</td>
                        <td><button class="btn-table">Renewal</button></td>
                    </tr>
                    <tr>
                        <td class="book-title">Database design</td>
                        <td>25/11/2024</td>
                        <td class="text-warning">09/12/2024</td>
                        <td><button class="btn-table">Return</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="regulations-box">
            <h4><i class="fas fa-lightbulb"></i> REGULATIONS:</h4>
            <ul>
                <li>Each member can borrow a maximum of 3 books at a time.</li>
                <li>Borrowing period: 14 days.</li>
                <li>Account will be locked for 7 days if books are returned late.</li>
            </ul>
        </div>
    </main>
</div>

<?php include 'change_password.php'; ?>

<?php include '../app/views/layouts/footer.php'; ?>
</body>
</html>