<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-notifications">
    <h1>Notification Management</h1>
    <a href="/admin/notifications/create" class="btn btn-primary">Create New Notification</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Notifications will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
