<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-transactions">
    <h1>Transaction Management</h1>
    <a href="/admin/transactions/pending" class="btn btn-primary">Pending Requests</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Transactions will be displayed here -->
        </tbody>
    </table>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
