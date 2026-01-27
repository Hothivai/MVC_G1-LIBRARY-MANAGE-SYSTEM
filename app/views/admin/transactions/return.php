<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-return-transaction">
    <h1>Process Book Return</h1>
    <form method="POST" action="/admin/transactions/return">
        <!-- Return form will be displayed here -->
        <button type="submit" class="btn btn-primary">Confirm Return</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
