<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-notification-create">
    <h1>Create New Notification</h1>
    <form method="POST" action="/admin/notifications">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="message">Content:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <div class="form-group">
            <label for="type">Notification Type:</label>
            <select id="type" name="type" required>
                <option value="info">Information</option>
                <option value="warning">Warning</option>
                <option value="error">Error</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_id">Send To User:</label>
            <select id="user_id" name="user_id">
                <option value="">All Users</option>
                <!-- Users will be listed here -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Send Notification</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
