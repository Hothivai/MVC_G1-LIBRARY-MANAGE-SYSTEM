<?php ?>
<?php include '../app/views/layouts/header.php'; ?>

<section class="admin-approve-transaction">
    <h1>Duyệt Mượn Sách</h1>
    <form method="POST" action="/admin/transactions/approve">
        <!-- Transaction approval form will be displayed here -->
        <button type="submit" class="btn btn-primary">Duyệt</button>
    </form>
</section>

<?php include '../app/views/layouts/footer.php'; ?>
