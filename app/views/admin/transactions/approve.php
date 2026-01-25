<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-approve-transaction">
    <h1>Approve Transaction</h1>
    <form method="POST" action="/admin/transactions/approve">
        <!-- Transaction approval form will be displayed here -->
        <button type="submit" class="btn btn-primary">Approve</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
