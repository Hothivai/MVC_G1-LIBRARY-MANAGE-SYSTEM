
<?php require_once __DIR__ . '/../../layouts/header.php'; ?>
<link rel="stylesheet" href="/css/notifications.css">

<div class="notification-wrapper">
    <h2>Thông báo</h2>

    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $n): ?>
            <div class="notification-item">
                <h4><?= htmlspecialchars($n['title']) ?></h4>
                <p><?= htmlspecialchars($n['message']) ?></p>
                <small><?= $n['created_at'] ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty">
            Không có thông báo nào 
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
