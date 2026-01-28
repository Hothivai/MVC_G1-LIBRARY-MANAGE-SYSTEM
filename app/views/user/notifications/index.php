<?php ?>
<?php include '../app/views/layouts/header.php'; ?>
<h3>Thông báo</h3>

<?php foreach ($notifications as $n): ?>
    <div class="notification-item">
        <strong><?= $n['title'] ?></strong>
        <p><?= $n['message'] ?></p>
        <small><?= $n['created_at'] ?></small>
    </div>
<?php endforeach; ?>


<?php include '../app/views/layouts/footer.php'; ?>
