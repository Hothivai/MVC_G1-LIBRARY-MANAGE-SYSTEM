<?php
require_once dirname(__DIR__, 2) . '/layouts/header.php';
?>

<div class="notification-wrapper">
    <h3>Notifications</h3>

    <?php foreach ($notifications as $n): ?>
        <div class="notification-item notification-<?= $n['type'] ?>">
            <div class="notification-title">
                <?= htmlspecialchars($n['title']) ?>
            </div>
            <p class="notification-message">
                <?= htmlspecialchars($n['message']) ?>
            </p>
            <small class="notification-time">
                <?= $n['created_at'] ?>
            </small>
        </div>
    <?php endforeach; ?>
</div>

<?php
require_once dirname(__DIR__, 2) . '/layouts/footer.php';
?>

